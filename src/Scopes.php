<?php
/**
 * User: Aleksandrov Artem
 * Date: 22.10.2019
 * Time: 20:59
 */

namespace kradwhite\myTarget\api\oauth2;

/**
 * Права доступа определяют какие действия может произвести API-клиент с данными, предоставившего доступ аккаунта.
 * Необходимые права указываются через запятую в параметре "scope" запроса доступа у пользователя в схеме
 * Authorization Code Grant. В зависимости от типа пользователя запрашиваемые права доступа делятся на три группы.
 * Class Scopes
 * @package kradwhite\myTarget\api\oauth2
 * @link https://target.my.com/adv/api-marketing/doc/authorization
 */
class Scopes
{
    /**
     * Для обычного пользователя-рекламодателя
     * чтение статистики и РК
     * @var string
     */
    const read_ads = 'read_ads';

    /**
     * Для обычного пользователя-рекламодателя, для пользователей-менеджеров
     * чтение денежных транзакций и баланса
     * @var string
     */
    const read_payments = 'read_payments';

    /**
     * Для обычного пользователя-рекламодателя
     * создание и редактирование настроек РК, баннеров, аудиторий (ставки, статус, таргетинги и т.п.)
     * @var string
     */
    const create_ads = 'create_ads';

    /**
     * Для пользователей-агентств и пользователей-представительств
     * создание новых клиентов
     * @var string
     */
    const create_clients = 'create_clients';

    /**
     * Для пользователей-агентств и пользователей-представительств
     * просмотр клиентов и операции от их имени
     * @var string
     */
    const read_clients = 'read_clients';

    /**
     * Для пользователей-агентств и пользователей-представительств
     * переводы средств на счёта клиентов и обратно
     * @var string
     */
    const create_agency_payments = 'create_agency_payments';

    /**
     * Для пользователей-менеджеров
     * просмотр клиентов и операции от их имени
     * @var string
     */
    const read_manager_clients = 'read_manager_clients';

    /**
     * Для пользователей-менеджеров
     * изменение параметров клиентов
     * @var string
     */
    const edit_manager_clients = 'edit_manager_clients';

    /**
     * Абсолютно все
     * @return string
     */
    public static function all(): string
    {
        return implode(',', [
            self::read_ads,
            self::read_payments,
            self::create_ads,
            self::create_clients,
            self::read_clients,
            self::create_agency_payments,
            self::read_manager_clients,
            self::edit_manager_clients
        ]);
    }

    /**
     * Все для обычного пользователя-рекламодателя
     * @return string
     */
    public static function allForClient(): string
    {
        return self::common([self::read_ads, self::read_payments, self::create_ads]);
    }

    /**
     * Все для пользователей-агентств и пользователей-представительств
     * @return string
     */
    public static function allForAgencyAndDelegate(): string
    {
        return self::common([self::create_clients, self::read_clients, self::create_agency_payments]);
    }

    /**
     * Все для пользователей-менеджеров
     * @return string
     */
    public static function allForManager(): string
    {
        return self::common([self::read_payments, self::read_manager_clients, self::edit_manager_clients]);
    }

    /**
     * Для всех только на чтение
     * @return string
     */
    public static function allForRead(): string
    {
        return self::common([self::read_ads, self::read_payments, self::read_clients, self::read_manager_clients]);
    }

    /**
     * Выборочные scopes
     * @param array $scopes
     * @return string
     */
    public static function common(array $scopes): string
    {
        return implode(',', $scopes);
    }
}
