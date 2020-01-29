<?php

namespace A1ex7\Cpa\Lead;

use A1ex7\Cpa\Interfaces\Lead\LeadParser;
use A1ex7\Cpa\Models\CpaCookie;
use A1ex7\Cpa\Models\Lead;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class LeadService
{
    const COOKIE_KEY = '_cpa_uuid';
    /**
     * @var LeadParser
     */
    protected $parser;

    /**
     * LeadService constructor.
     * @param LeadParser $parser
     */
    public function __construct(LeadParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Convert user to Lead when he visited referral link
     *
     * @param  Model|int|string $model
     * @param  string|array $urls
     * @return Lead|null
     */
    public function create($model, $urls): ?Lead
    {
        $modelId = $model instanceof Model ? $model->getKey() : $model;

        foreach ((array) $urls as $url) {
            $leadInfo = $this->parser->parse($url);
            if ($leadInfo instanceof LeadInfo) {
                break;
            }
        }
        if (empty($leadInfo)) {
            return null;
        }

        /** @var Lead $lead */
        $lead = Lead::query()->updateOrCreate(
            [
                'source'  => $leadInfo->getSource(),
                'user_id' => $modelId,
            ],
            [
                'source'         => $leadInfo->getSource(),
                'config'         => $leadInfo->getConfig(),
                'user_id'        => $modelId,
                'last_cookie_at' => now(),
            ]
        );

        return $lead;
    }

    /**
     * Convert guests to Lead when they visited referral link
     * for guest we just store lead info to cookie
     *
     * @param string $url request full url
     * @return Model|null
     */
    public function storeToCookie(string $url): ?Model
    {
        $leadInfo = $this->parser->parse($url);
        if (empty($leadInfo)) {

            // if other paid source - delete cookie
            $uuid = Cookie::get(self::COOKIE_KEY);
            optional(CpaCookie::query()->find($uuid))->delete();

            return null;
        }

        $uuid = Cookie::get(self::COOKIE_KEY) ?? (string) Str::uuid();
        $cpaCookie = CpaCookie::query()->updateOrCreate(
            ['id' => $uuid],
            [
                'id'      => $uuid,
                'payload' => serialize($leadInfo),
            ]
        );

        Cookie::queue(self::COOKIE_KEY, $uuid, Config::get('cpa.cookie_period'));

        return $cpaCookie;
    }

    /**
     * When user authorized we get Lead info from
     * cookie and convert user to Lead
     *
     * @param  Model|int|string  $model
     * @return Lead|null
     */
    public function createFromCookie($model): ?Lead
    {
        $leadModel = Config::get('cpa.lead_model');
        if (
            Cookie::has(self::COOKIE_KEY)
            && !empty($cookieId = Cookie::get(self::COOKIE_KEY))
            && !empty($cpaCookie = CpaCookie::query()->find($cookieId))
        ) {
            $modelId  = $model instanceof Model ? $model->getKey() : $model;
            $leadInfo = unserialize($cpaCookie['payload'], ['allowed_classes' => true]);
            $user = $leadModel::query()->find($modelId);
            if (empty($leadInfo) || empty($user)) {
                return null;
            }

            /** @var Lead $lead */
            $lead = Lead::query()->updateOrCreate(
                [
                    'source'  => $leadInfo->getSource(),
                    'user_id' => $user->getKey(),
                ],
                [
                    'source'         => $leadInfo->getSource(),
                    'config'         => $leadInfo->getConfig(),
                    'user_id'        => $user->getKey(),
                    'last_cookie_at' => $cpaCookie->updated_at,
                ]
            );

            if ($lead && $cpaCookie->delete()) {
                Cookie::forget(self::COOKIE_KEY);
            }

            return $lead;
        }

        return null;
    }

    /**
     * Get Lead Info for current user stored by last visited cpa link
     *
     * @param  Model|int|string  $model
     * @return Lead|null
     */
    public function getLastLeadByUser($model): ?Lead
    {
        $modelId = $model instanceof Model ? $model->getKey() : $model;
        /** @var Lead $lead */
        $lead = Lead::query()
            ->where('user_id', $modelId)
            ->where('last_cookie_at', '>', now()->subMinutes(Config::get('cpa.cookie_period')))
            ->latest('updated_at')->first();

        return $lead;
    }
}