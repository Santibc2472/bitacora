<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;
global $absdashboardtext;


/*
 * English language file
 */

$absdashboardtext['title']                   = 'A+ Booking System';
$absdashboardtext['service']                 = 'Book Everything Unlimited';
$absdashboardtext["connection"]              = "Подключение";
$absdashboardtext["connect_to"]              = "Подключить к";
$absdashboardtext["connected_to"]            = "Подключено к";
$absdashboardtext['i_m_agree']               = 'Я принимаю <a target=\'blank\' href=\''.$ABookingSystem['terms_and_conditions'].'\'>правила и условия</a>';
$absdashboardtext["must_agree"]              = "Для использования нашего сервиса необходимо принять правила и условия";
$absdashboardtext["calendars"]               = "Календари";
$absdashboardtext["reservations"]            = "Бронирования";
$absdashboardtext["network"]                 = "Сеть";
$absdashboardtext["my_account"]              = "Моя учетная запись";
$absdashboardtext["support"]                 = "Поддержка";
$absdashboardtext["listings"]                = "Объявления";
$absdashboardtext['connect_video']           = 'Once you\'ve created your account, you can follow the steps in this <a target=\'blank\' href=\''.$ABookingSystem['how_to_connect_video'].'\'>video</a> to connect.';
$absdashboardtext['get_key_info']            = 'Get Key<i>Once you\'ve created your account go to book.eu.com and sign in. Then go to \'My Account\' and copy \'User Key\'.</i>';

$absdashboardtext["delete_button"]           = "Удалить";
$absdashboardtext["reject_button"]           = "Отклонить";
$absdashboardtext["approve_button"]          = "Утвердить";
$absdashboardtext["get_code"]                = "Поделиться";
$absdashboardtext["calendar"]                = "Календарь";
$absdashboardtext["group"]                   = "Группа";
$absdashboardtext["my_calendars"]            = "Мои календари";
$absdashboardtext['more_prices']             = 'More prices';


// Loader
$absdashboardtext["loading"]                 = "Загрузка…";
$absdashboardtext["wait"]                    = "Пожалуйста, подождите! Загрузка скоро завершится.";
$absdashboardtext["completed"]               = "Завершено";
$absdashboardtext["refresh"]                 = "Пожалуйста, подождите! Производится обновление.";
$absdashboardtext["saved"]                   = "Сохранено";
$absdashboardtext["save_success"]            = "Данные успешно сохранены.";
$absdashboardtext["delete"]                  = "Вы уверены, что хотите удалить этот объект?";
$absdashboardtext["reject"]                  = "Вы уверены, что хотите отклонить этот объект?";
$absdashboardtext["deleted"]                 = "Календарь или группа успешно удалены.";
$absdashboardtext["rejected"]                = "Календарь или группа успешно отклонены.";
$absdashboardtext["share"]                   = "Поделиться календарем";
$absdashboardtext["share_on"]                = "Поделиться в";
$absdashboardtext["share_fb_link"]           = "Ссылка в Facebook";
$absdashboardtext['share_fb_text']           = 'Если у вас уже есть корпоративная страница в Facebook, просто скопируйте `<i>'.$absdashboardtext['share_fb_link'].'</i>` и следуйте инструкции, представленной в данном <a href=\''.$ABookingSystem['share_fb_link_video'].'\' target=\'_blank\'>ролике</a>. В противном случае, создайте вашу страницу в Facebook, нажав <a href=\''.$ABookingSystem['share_fb_link_create_business'].'\' target=\'_blank\'>здесь</a>';
$absdashboardtext["share_website"]           = "Тип сайта";
$absdashboardtext["share_wordpress"]         = "Короткий код";
$absdashboardtext['share_wordpress_text']    = 'Если вы уже установили плагин для Wordpress, просто скопируйте `<i>'.$absdashboardtext['share_wordpress'].'</i>` и следуйте инструкции, представленной в данном <a href=\''.$ABookingSystem['share_wp_link_video'].'\' target=\'_blank\'>ролике</a>. В противном случае, установите плагин для Wordpress, нажав <a href=\''.$ABookingSystem['share_wp_link_download'].'\' target=\'_blank\'>здесь</a>';
$absdashboardtext['share_wix']               = 'Ссылка в Wix';
$absdashboardtext['share_wix_text']          = 'Если у вас уже есть страница в Wix, просто скопируйте `<i>'.$absdashboardtext['share_wix'].'</i>` и следуйте инструкции, представленной в данном <a href=\''.$ABookingSystem['share_wix_link_video'].'\' target=\'_blank\'>ролике</a>. В противном случае, создайте вашу страницу в Wix, нажав <a href=\''.$ABookingSystem['share_wix_link_create_wix_website'].'\' target=\'_blank\'>здесь</a>';
$absdashboardtext['share_weebly']            = 'Ссылка в Weebly';
$absdashboardtext['share_weebly_text']       = 'Если у вас уже есть страница в Weebly, просто скопируйте `<i>'.$absdashboardtext['share_weebly'].'</i>` и следуйте инструкции, представленной в данном <a href=\''.$ABookingSystem['share_weebly_link_video'].'\' target=\'_blank\'>ролике</a>. В противном случае, создайте вашу страницу в Weebly, нажав <a href=\''.$ABookingSystem['share_weebly_link_create_weebly_website'].'\' target=\'_blank\'>здесь</a>';
$absdashboardtext["share_other_files"]       = "Наша библиотека";
$absdashboardtext["share_other_short"]       = "Короткий код";
$absdashboardtext['share_other_text']        = '1 - Скопируйте `<i>'.$absdashboardtext['share_other_files'].'</i>` и добавьте ее в раздел head вашего сайта.<br>2 - После этого скопируйте `<i>'.$absdashboardtext['share_other_short'].'</i>` и установите его в раздел body вашего сайта.<br>3  Добавьте ссылку на сайт в настройках вашего объекта, используя раздел \'Разрешенные сайты\'. <br>Пожалуйста, посмотрите данный <a href=\''.$ABookingSystem['share_other_link_video'].'\' target=\'_blank\'>ролик</a> чтобы понять, как все происходит';


// Info
$absdashboardtext["disconnect"]              = "Вы уверены, что хотите отключиться?";
$absdashboardtext["no_dashboard"]            = "Вы не сможете использовать нашу панель управления.";
$absdashboardtext["button_yes"]              = "ДА, я понимаю.";
$absdashboardtext["button_no"]               = "НЕТ, отказаться.";


// Warning
$absdashboardtext["warning"]             = "Внимание!!!";
$absdashboardtext["warning_error"]       = "Неправильные реквизиты. Пожалуйста, проверьте правильность реквизитов и повторите попытку";
$absdashboardtext["warning_contact"]     = "или свяжитесь со службой поддержки";
$absdashboardtext["warning_delete"]      = "Ой! Что-то пошло не так. Пожалуйста, повторите попытку позднее.";
$absdashboardtext["warning_overbooking"] = "Ой! Объект %s недоступен в выбранные даты.";


// New Calendar
$absdashboardtext["new_calendar"]                = "Новый календарь";
$absdashboardtext["new_group"]                   = "Новая группа";
$absdashboardtext["calendar_name"]               = "Название";
$absdashboardtext["website_name"]                = "Сайт";
$absdashboardtext["calendar_location"]           = "Расположение";
$absdashboardtext["your_calendar_location"]      = "Расположение вашего календаря…";
$absdashboardtext["calendar_address"]            = "Полный адрес";
$absdashboardtext["currency"]                    = "Валюта";
$absdashboardtext["category"]                    = "Категория";
$absdashboardtext["calendar_type"]               = "Тип календаря";
$absdashboardtext["calendar_type_days"]          = "Дни";
$absdashboardtext["calendar_type_hours"]         = "Дни и часы";
$absdashboardtext["reservations_type"]           = "Тип бронирования";
$absdashboardtext["reservations_type_free"]      = "Бесплатное";
$absdashboardtext["reservations_type_paid"]      = "Платное";
$absdashboardtext["description"]                 = "Описание";
$absdashboardtext["my_calendar"]                 = "Мой календарь";
$absdashboardtext["my_group"]                    = "Моя группа";
$absdashboardtext["optional"]                    = "Опционально";
$absdashboardtext["create_calendar"]             = "СОЗДАТЬ КАЛЕНДАРЬ";
$absdashboardtext["create_group"]                = "СОЗДАТЬ ГРУППУ";
$absdashboardtext["cancel"]                      = "ОТМЕНА";
$absdashboardtext["yes"]                         = "ДА";
$absdashboardtext["no"]                          = "НЕТ";
$absdashboardtext["calendars_limit_reached"]     = "Вы достигли максимального количества календарей. Вы не можете добавить более %s календарей.";
$absdashboardtext["calendars_upgrade_account"]   = "Перейдите на тариф PRO, чтобы добавить дополнительные календари.";
$absdashboardtext["groups_limit_reached"]        = "Вы достигли максимального количества групп. Вы не можете добавить более %s групп.";
$absdashboardtext["groups_upgrade_account"]      = "Перейдите на тариф PRO, чтобы добавить дополнительные группы.";
$absdashboardtext["calendars_add_calendar"]      = "Календарь";
$absdashboardtext["calendars_calendar_type"]     = "Категория";
$absdashboardtext["calendars_rules"]             = "Правила календаря";
$absdashboardtext["calendars_allowed"]           = "Разрешенные сайты";


// Settings
$absdashboardtext["availability_price"]      = "Доступность и цена";
$absdashboardtext["availability"]            = "Доступность";
$absdashboardtext["settings"]                = "Настройки";
$absdashboardtext["form"]                    = "Форма";
$absdashboardtext["notifications"]           = "Уведомления";
$absdashboardtext["sync"]                    = "Синхронизация";
$absdashboardtext["sync_settings"]           = "Синхронизировать настройки - ссылки в iCal";
$absdashboardtext["sync_my_settings"]        = "Синхронизировать настройки - мои ссылки в iCal";
$absdashboardtext["sync_airbnb"]             = "Airbnb";
$absdashboardtext["sync_booking_com"]        = "Booking.com";
$absdashboardtext["sync_google_calendar"]    = "Google";
$absdashboardtext["sync_homeaway_com"]       = "HomeAway";
$absdashboardtext["sync_homestay_com"]       = "HomeStay";
$absdashboardtext["sync_vrbo_com"]           = "VRBO";
$absdashboardtext["sync_flipkey_com"]        = "Flipkey";
$absdashboardtext["sync_other_calendar"]     = "Другое";

$absdashboardtext["default_settings"]            = "По умолчанию";
$absdashboardtext["advanced_settings"]           = "Расширенный";
$absdashboardtext["save"]                        = "Сохранить";
$absdashboardtext["hint"]                        = "Подсказка!";
$absdashboardtext["day_hours_available"]         = "Количество доступных элементов должно быть не менее 1";
$absdashboardtext["day_hours_booked"]            = "Количество забронированных элементов.";
$absdashboardtext["yearly"]                      = "Ежегодно";
$absdashboardtext["weekaday"]                    = "Еженедельно";
$absdashboardtext["monthly"]                     = "Ежемесячно";
$absdashboardtext["weeks"]                       = "Недель";
$absdashboardtext["custom_date"]                 = "Произвольный период";
$absdashboardtext["period"]                      = "Период";
$absdashboardtext["main_settings"]               = "Основные настройки";
$absdashboardtext["cancellation_settings"]       = "Отмена";
$absdashboardtext["cancellation_allowed"]        = "Разрешена";
$absdashboardtext["cancellation_no"]             = "Нет";
$absdashboardtext["cancellation_before_day"]     = "за один день";
$absdashboardtext["cancellation_before_days"]    = "за %s дней";
$absdashboardtext["cancellation_before_week"]    = "за одну неделю";
$absdashboardtext["cancellation_before_weeks"]   = "за %s недель";
$absdashboardtext["cancellation_before_month"]   = "за один месяц";
$absdashboardtext["cancellation_before_months"]  = "за %s месяцев";
$absdashboardtext["cancellation_refund"]         = "Возврат средств";
$absdashboardtext["cancellation_refund_info"]    = "Процент суммы к возврату (от 0 до 100). Без учета сервисного сбора.";
$absdashboardtext["rules_settings"]              = "Правила";

// Availability
$absdashboardtext["status"]                      = "Состояние";
$absdashboardtext["status_available"]            = "Доступно";
$absdashboardtext["status_unavailable"]          = "Недоступно";
$absdashboardtext["status_booked"]               = "Забронировано";
$absdashboardtext["prices"]                      = "Цены";
$absdashboardtext["price"]                       = "В день";
$absdashboardtext["monthly_price"]               = "В месяц";
$absdashboardtext["weekly_price"]                = "В неделю";
$absdashboardtext["weekend_price"]               = "Выходные";
$absdashboardtext["notes"]                       = "Примечания";
$absdashboardtext["notes_write"]                 = "Запишите ваши примечания…";
$absdashboardtext["your_price"]                  = "Ваша цена";
$absdashboardtext["service_fee"]                 = "Сервисный сбор";
$absdashboardtext["final_price"]                 = "Окончательная цена";
$absdashboardtext['estimated_price']             = 'Ориентировочная цена';
$absdashboardtext['estimated_price_info']        = 'The price may be different because our service fee depends on the total amount. (Our percentage for the service fee is lower when the amount increases). The final price will also include the payment processing fee (Paypal fee). If the reservation is made from the affiliate site it will include the affiliate fee also.';
$absdashboardtext['service_fee_info']            = 'This helps us run and develop our booking services and offer fast support. It includes VAT/GST.';
$absdashboardtext["year"]                        = "Год";
$absdashboardtext["week"]                        = "Неделя";
$absdashboardtext["availability_warning_head"]   = "Вы хотите сохранить данные настройки для всех номеров и комнат вашего объекта?";
$absdashboardtext["availability_warning"]        = "Вы уверены, что хотите сделать это? Если вы хотите изменить настройки только одного номера, пожалуйста, выберите его.";

// Form
$absdashboardtext["email"]               = "Эл. почта";
$absdashboardtext["phone"]               = "Телефон";
$absdashboardtext["via_email"]           = "по эл. почте";
$absdashboardtext["via_sms"]             = "по СМС";
$absdashboardtext["form_use"]            = "Использовать";
$absdashboardtext["form_required"]       = "Обязательно";
$absdashboardtext["for_host"]            = "для владельца";
$absdashboardtext["for_guest"]           = "для гостя";
$absdashboardtext["via_email_host"]      = "по эл. почте";
$absdashboardtext["via_sms_host"]        = "по СМС";
$absdashboardtext["via_email_guest"]     = "по эл. почте";
$absdashboardtext["via_sms_guest"]       = "по СМС";
$absdashboardtext["send"]                = "Отправить";
$absdashboardtext["sender"]              = "Отправитель";
$absdashboardtext["language"]            = "Язык";
$absdashboardtext["message"]             = "Сообщение";
$absdashboardtext["autodetect"]          = "Автоматическое определение";
$absdashboardtext["the_field"]           = "Поле";
$absdashboardtext["already_exist"]       = "уже существует в нашей базе данных.";
$absdashboardtext["the_fields"]          = "Поля";
$absdashboardtext["and"]                 = "и";
$absdashboardtext["must_be_identique"]   = "должны совпадать.";

// Week Days
$absdashboardtext["weekday"]     = "День недели";
$absdashboardtext["monday"]      = "Понедельник";
$absdashboardtext["tuesday"]     = "Вторник";
$absdashboardtext["wednesday"]   = "Среда";
$absdashboardtext["thursday"]    = "Четверг";
$absdashboardtext["friday"]      = "Пятница";
$absdashboardtext["saturday"]    = "Суббота";
$absdashboardtext["sunday"]      = "Воскресенье";

// Months
$absdashboardtext["month"]       = "Месяц";
$absdashboardtext["january"]     = "Январь";
$absdashboardtext["february"]    = "Февраль";
$absdashboardtext["march"]       = "Март";
$absdashboardtext["april"]       = "Апрель";
$absdashboardtext["may"]         = "Май";
$absdashboardtext["june"]        = "Июнь";
$absdashboardtext["july"]        = "Июль";
$absdashboardtext["august"]      = "Август";
$absdashboardtext["september"]   = "Сентябрь";
$absdashboardtext["october"]     = "Октябрь";
$absdashboardtext["november"]    = "Ноябрь";
$absdashboardtext["december"]    = "Декабрь";
$absdashboardtext['today']       = 'сегодня';
$absdashboardtext['list']        = 'Список';
$absdashboardtext['more']        = 'больше';


// Errors
$absdashboardtext["error_is_required"]           = "Пожалуйста, проверьте данное поле!";
$absdashboardtext["error_is_email"]              = "Неправильный электронный адрес!";
$absdashboardtext["error_is_phone"]              = "Неправильный номер телефона!";
$absdashboardtext["error_is_iban"]               = "Неправильный IBAN-номер!";
$absdashboardtext["error_is_swift"]              = "Неправильный SWIFT-код!";
$absdashboardtext["error_is_lower_than"]         = "Не может быть более %s!";
$absdashboardtext["error_is_higher_than"]        = "Не может быть менее %s!";
$absdashboardtext["error_invalid_url"]           = "Неправильный сайт!";
$absdashboardtext["error_min_chars"]             = "Данное поле должно содержать не менее %s символов!";
$absdashboardtext["error_allowed_characters"]    = "Разрешено только %s символов!";

// Network - settings
$absdashboardtext["network_name"]                        = "Название сети";
$absdashboardtext["network_settings"]                    = "Настройки";
$absdashboardtext["network_payments"]                    = "Платежные системы";
$absdashboardtext["commission"]                          = "Комиссия";
$absdashboardtext["commission_type"]                     = "Тип комиссии";
$absdashboardtext["commission_type_fixed"]               = "Фиксированная";
$absdashboardtext["commission_type_percent"]             = "Процент";
$absdashboardtext["roles_for_owners"]                    = "Права владельца";
$absdashboardtext["roles_for_owners_info"]               = "Опишите права владельца (через запятую)";
$absdashboardtext["roles_for_customers"]                 = "Права клиента";
$absdashboardtext["roles_for_customers_info"]            = "Опишите права клиента (через запятую)";
$absdashboardtext["allow_guests_to_book"]                = "Гости могут бронировать";
$absdashboardtext["allow_guests_to_book_info"]           = "Разрешите бронирование для гостей";
$absdashboardtext["use_settings"]                        = "Использовать настройки";
$absdashboardtext["use_settings_info"]                   = "Владельцы могут использовать настройки календаря";
$absdashboardtext["use_form_settings"]                   = "Использовать настройки формы";
$absdashboardtext["use_form_settings_info"]              = "Владельцы могут использовать настройки формы";
$absdashboardtext["use_notifications"]                   = "Использовать настройки уведомлений";
$absdashboardtext["use_notifications_info"]              = "Владельцы могут использовать настройки уведомлений";
$absdashboardtext["use_sync"]                            = "Использовать синхронизацию";
$absdashboardtext["use_sync_info"]                       = "Владельцы могут использовать синхронизацию";
$absdashboardtext["add_calendar"]                        = "Добавление календарей и групп";
$absdashboardtext["add_calendar_info"]                   = "Владельцы могут добавлять календари и группы";
$absdashboardtext["delete_calendar"]                     = "Удаление календарей и групп";
$absdashboardtext["delete_calendar_info"]                = "Владельцы могут удалять календари и группы";
$absdashboardtext["create_at_register"]                  = "Календарь для каждого пользователя";
$absdashboardtext["create_at_register_info"]             = "Автоматическое создание календаря во время регистрации и его привязка к пользователю.";
$absdashboardtext["create_for_post"]                     = "Календарь для каждой записи";
$absdashboardtext["create_for_post_info"]                = "Автоматическое создание календаря во время создания записи и его привязка к записи.";
$absdashboardtext["create_for_custom_post"]              = "Календарь для каждой пользов. записи";
$absdashboardtext["create_for_custom_post_info"]         = "Автоматическое создание календаря во время создания пользов. записи и его привязка к записи.";
$absdashboardtext["create_for_custom_post_name"]         = "Пользовательское название записи";
$absdashboardtext["create_for_custom_post_name_info"]    = "Автоматическое создание календаря при выборе пользовательского названия записи.";
$absdashboardtext["max_calendars"]                       = "Макс. календарей";
$absdashboardtext["max_calendars_info"]                  = "Максимальное количество календарей. 0 - без ограничений.";
$absdashboardtext["default_reservations_type"]           = "Тип бронирования по умолчанию";
$absdashboardtext["default_calendar_type"]               = "Тип календаря по умолчанию";
$absdashboardtext["default_category"]                    = "Категория по умолчанию";
$absdashboardtext["default_currency"]                    = "Валюта по умолчанию";

// Network - payment systems
$absdashboardtext["use_stripe"]                          = "Использовать stripe";
$absdashboardtext["use_stripe_info"]                     = "Разрешить использование платежной системы stripe";
$absdashboardtext["stripe_secret_key"]                   = "Секретный код stripe";
$absdashboardtext["stripe_secret_key_info"]              = "Укажите ваш секретный код в stripe";
$absdashboardtext["stripe_publishable_key"]              = "Открытый код в stripe";
$absdashboardtext["stripe_publishable_key_info"]         = "Укажите ваш открытый код в stripe";
$absdashboardtext["use_test_stripe"]                     = "Использовать stripe для тестирования";
$absdashboardtext["use_test_stripe_info"]                = "Разрешить использование платежной системы stripe для тестирования";
$absdashboardtext["stripe_test_secret_key"]              = "Тестовый секретный код stripe";
$absdashboardtext["stripe_test_secret_key_info"]         = "Укажите ваш секретный код в stripe для тестирования";
$absdashboardtext["stripe_test_publishable_key"]         = "Тестовый открытый код в stripe";
$absdashboardtext["stripe_test_publishable_key_info"]    = "Укажите ваш открытый код в stripe для тестирования";

// Reservations
$absdashboardtext["reservations_for"]                    = "Бронирования для";
$absdashboardtext["reservations_contact"]                = "Контактные данные";
$absdashboardtext["reservations_email"]                  = "Эл. почта";
$absdashboardtext["reservations_phone"]                  = "Телефон";
$absdashboardtext["reservations_start_date"]             = "Прибытие";
$absdashboardtext["reservations_end_date"]               = "Отъезд";
$absdashboardtext["reservations_day_included"]           = "включено";
$absdashboardtext["reservations_owner_price"]            = "Цена владельца";
$absdashboardtext["reservations_your_price"]             = "Ваша цена";
$absdashboardtext["reservations_just_price"]             = "Цена";
$absdashboardtext["reservations_service_fee"]            = "Сервисный сбор";
$absdashboardtext["reservations_network_fee"]            = "Сетевой сбор";
$absdashboardtext["reservations_total_price"]            = "Общая стоимость";
$absdashboardtext["reservations_no_items"]               = "Элементы";
$absdashboardtext["reservations_add"]                    = "Добавить бронирование";
$absdashboardtext["reservations_add_details"]            = "Информация о бронирования";
$absdashboardtext["reservations_add_check_in"]           = "Прибытие";
$absdashboardtext["reservations_add_check_out"]          = "Отъезд";
$absdashboardtext["reservations_adding"]                 = "Сохранение бронирование";
$absdashboardtext["reservations_from"]                   = "Бронирование из";
$absdashboardtext["reservations_from_admin"]             = "Владелец";
$absdashboardtext["reservations_from_calendar"]          = "Гость";
$absdashboardtext["reservations_from_booking_com"]       = "Booking.com";
$absdashboardtext["reservations_from_airbnb_com"]        = "Airbnb.com";
$absdashboardtext["reservations_from_google_calendar"]   = "Google Calendar";
$absdashboardtext["reservations_from_homeaway_com"]      = "Homeaway.com";
$absdashboardtext["reservations_from_homestay_com"]      = "Homestay.com";
$absdashboardtext["reservations_from_vrbo_com"]          = "VRBO.com";
$absdashboardtext["reservations_from_flipkey_com"]       = "Flipkey.com";
$absdashboardtext["reservations_from_other_calendar"]    = "Другой календарь";
$absdashboardtext["reservation_cancel_question"]         = "Вы уверены, что хотите отменить данное бронирование?";
$absdashboardtext["reservation_cancel_message"]          = "Отменив бронирование, вы получите $%s";
$absdashboardtext["reservation_cancel_warning"]          = "Данное бронирование не найдено, было отменено ранее, или не может быть отменено.";
$absdashboardtext["reservation_cancel_success"]          = "Бронирование успешно отменено.";
$absdashboardtext["reservation_cancel_error"]            = "Данное бронирование невозможно отменить. Пожалуйста, попробуйте позднее.";
$absdashboardtext["reservations_cancel_btn"]             = "Отменить бронирование";
$absdashboardtext["reservations_cancel_txt"]             = "Отменить бронирование?";
$absdashboardtext["reservations_cancel_reason"]          = "Причина";

// My Account
$absdashboardtext["my_withdraws"]                        = "Мои снятия";
$absdashboardtext["withdraw"]                            = "Вывести средства";
$absdashboardtext["search_payment"]                      = "Поиск платежа";
$absdashboardtext["withdraw_name"]                       = "Полное имя";
$absdashboardtext["withdraw_company"]                    = "Компания";
$absdashboardtext["withdraw_bank_name"]                  = "Название банка";
$absdashboardtext["withdraw_bank_iban"]                  = "IBAN банка";
$absdashboardtext["withdraw_bank_swift"]                 = "SWIFT банка";
$absdashboardtext["withdraw_amount"]                     = "Сумма";
$absdashboardtext["new_withdraw"]                        = "Снятие";
$absdashboardtext["create_withdraw"]                     = "ОТПРАВИТЬ";
$absdashboardtext["minimum_payout"]                      = "Недостаточно средств. Минимальная сумма для вывода средств - 50 долларов США.";
$absdashboardtext["money"]                               = "Деньги";
$absdashboardtext["money_earnings"]                      = "На счете";
$absdashboardtext['money_paid']                          = 'Received';
$absdashboardtext["my_account_reservations"]             = "Бронирования";
$absdashboardtext["my_account_reservations_upcoming"]    = "Предстоящие";
$absdashboardtext["my_account_reservations_past"]        = "Прошедшие";
$absdashboardtext["my_account_requests"]                 = "Запросы";
$absdashboardtext["my_account_api_details"]              = "API";
$absdashboardtext["my_account_api_user_key"]             = "Ключ пользователя";
$absdashboardtext["my_account_api_endpoint"]             = "Конечная точка";
$absdashboardtext["my_account_requests_calendar"]        = "Календарь";
$absdashboardtext["my_account_requests_dashboard"]       = "Панель управления";
$absdashboardtext["my_account_withdraw_status"]          = "Состояние платежа";
$absdashboardtext['my_account_withdraw_status_paid']     = 'Paid';
$absdashboardtext['my_account_withdraw_status_unpaid']   = 'Unpaid';
$absdashboardtext['my_account_withdraw_status_rejected'] = 'Rejected';
$absdashboardtext['my_account_withdraw_pay_date']        = 'Pay date';



// Statement
$absdashboardtext["statement"]                       = "Выписка";
$absdashboardtext["statements"]                      = "Выписки";
$absdashboardtext["statement_my_funds"]              = "Мои средства";
$absdashboardtext["statement_earnings"]              = "Доход";
$absdashboardtext["statement_vat"]                   = "НДС";
$absdashboardtext["statement_fees"]                  = "Сборы";
$absdashboardtext["statement_text"]                  = "Ваши бронирования и партнерские выплаты за последние 30 дней";
$absdashboardtext["statement_date"]                  = "Дата";
$absdashboardtext["statement_oder_id"]               = "ID заказа";
$absdashboardtext["statement_type"]                  = "Тип";
$absdashboardtext["statement_host_referral"]         = "Партнерский сбор владельца";
$absdashboardtext["statement_guest_referral"]        = "Партнерский сбор гостя";
$absdashboardtext["statement_service_fee"]           = "Сервисный сбор";
$absdashboardtext["statement_payment_fee"]           = "Платежный сбор";
$absdashboardtext["statement_refund"]                = "Возврат";
$absdashboardtext['statement_exchange']              = 'обмен';
$absdashboardtext["statement_service_fee_for"]       = "за";
$absdashboardtext["statement_booking"]               = "Бронирование";
$absdashboardtext["statement_invoice"]               = "Счет";
$absdashboardtext["statement_price"]                 = "Цена";
$absdashboardtext["statement_detail"]                = "Информация";
$absdashboardtext["statement_amount"]                = "Сумма";
$absdashboardtext["statement_view_invoices"]         = "Показать счета";
$absdashboardtext["statement_invoice_no"]            = "Номер счета";
$absdashboardtext["statement_invoice_date"]          = "Дата счета";
$absdashboardtext["statement_invoice_from"]          = "С";
$absdashboardtext["statement_invoice_to"]            = "По";
$absdashboardtext["statement_bookings"]              = "Бронирования";
$absdashboardtext["statement_rate"]                  = "Ставка";
$absdashboardtext["statement_invoice_total"]         = "Сумма счета";
$absdashboardtext["statement_invoice_description"]   = "Все суммы указаны в долларах США. Общая стоимость указана с учетом всех вычетов и возвратов.";



// Support
$absdashboardtext["my_tickets"]                  = "Мои обращения";
$absdashboardtext["ticket"]                      = "Обращение";
$absdashboardtext["ticket_subject"]              = "Тема";
$absdashboardtext["ticket_problem"]              = "Проблема";
$absdashboardtext["new_ticket"]                  = "Новое обращение";
$absdashboardtext["create_ticket"]               = "Создать обращение";
$absdashboardtext["status_unanswered"]           = "Обращение без ответа";
$absdashboardtext["status_answered"]             = "Обращение с ответом";
$absdashboardtext["status_resolved"]             = "Вопрос решен";
$absdashboardtext["working_hours"]               = "Рабочее время";
$absdashboardtext["monday_saturday"]             = "Пн. - Сб.";
$absdashboardtext["active_hours"]                = "09:00 - 17:00";
$absdashboardtext["your_reply"]                  = "Ваш ответ";
$absdashboardtext["reply_message"]               = "Сообщение";
$absdashboardtext["reply_message_required"]      = "Необходимо заполнить поле Сообщение!";
$absdashboardtext["reply_message_hint"]          = "Ваше сообщение";
$absdashboardtext["status_unsolved"]             = "В обработке";
$absdashboardtext["status_solved"]               = "Решено";
$absdashboardtext["status_not_possible_yet"]     = "В настоящее время невозможно";
$absdashboardtext["status_not_answered"]         = "Без ответа";
$absdashboardtext["close_ticket"]                = "Закрыть обращение";
$absdashboardtext["open_ticket"]                 = "Открыть обращение";
$absdashboardtext["search_ticket"]               = "Поиск обращения";

// Listings
$absdashboardtext["search_listing"]          = "Поиск объявления";
$absdashboardtext["search_listing_rules"]    = "Правила";
$absdashboardtext["search_listing_filters"]  = "Принадлежности";
$absdashboardtext["search_listing_reason"]   = "Причина";

// Custom account
$absdashboardtext["my_spaces"]                   = "Мои объекты";
$absdashboardtext["spaces"]                      = "Объекты";
$absdashboardtext["space"]                       = "Объект";
$absdashboardtext["add_space"]                   = "Здесь вы можете добавить ваш объект";
$absdashboardtext["add_space_in_content"]        = "Добавление вашего объекта";
$absdashboardtext["add_space_add"]               = "ДОБАВИТЬ";
$absdashboardtext["space_what_you_rent"]         = "Что именно вы хотите сдать в аренду?";
$absdashboardtext["space_next"]                  = "ДАЛЕЕ";
$absdashboardtext["space_rent_rooms"]            = "Комнаты или номера";
$absdashboardtext["space_rent_entire_space"]     = "Объект целиком";
$absdashboardtext["search_for_spaces"]           = "Поиск объекта…";
$absdashboardtext["search_for_events"]           = "Поиск мероприятия…";
$absdashboardtext["search_for_calendars"]        = "Поиск группы или календаря…";
$absdashboardtext["space_details"]               = "Информация объекта";
$absdashboardtext["space_name"]                  = "Название объекта";
$absdashboardtext["space_cover"]                 = "Фотография обложки";
$absdashboardtext["space_cover_info"]            = "Данная фотография будет отображаться на странице с общей информацией о вас";
$absdashboardtext["space_description"]           = "Описание";
$absdashboardtext["space_description_hint"]      = "Несколько слов о вашем объекте…";
$absdashboardtext["space_location"]              = "Расположение";
$absdashboardtext["space_address"]               = "Полный адрес";
$absdashboardtext["space_type"]                  = "Тип объекта";
$absdashboardtext["space_rooms"]                 = "Количество номеров";
$absdashboardtext["space_add"]                   = "ДОБАВИТЬ ОБЪЕКТ";
$absdashboardtext["space_limit_reached"]         = "Вы достигли максимального количества объектов. Вы не можете добавить более %s объектов.";
$absdashboardtext["space_upgrade_account"]       = "Перейдите на тариф PRO, чтобы добавить дополнительные объекты.";
$absdashboardtext["space_rooms_limit_reached"]   = "Вы достигли максимального количества комнат. Вы не можете добавить более %s комнат.";
$absdashboardtext["space_rooms_upgrade_account"] = "Перейдите на тариф PRO, чтобы добавить дополнительные комнаты.";
$absdashboardtext["spaces_add_calendar"]         = "Количество номеров";
$absdashboardtext["spaces_calendar_type"]        = "Тип объекта";
$absdashboardtext["spaces_rules"]                = "Правила объекта";
$absdashboardtext["space_rooms_adding"]          = "Добавление новых номеров";
$absdashboardtext["space_rooms_add"]             = "ДОБАВИТЬ НОМЕРА";
$absdashboardtext["space_price"]                 = "Цена";
$absdashboardtext["space_check_in_time"]         = "Прибытие";
$absdashboardtext["space_check_out_time"]        = "Отъезд";
$absdashboardtext["space_rejected"]              = "Ваш объект отклонен по следующей причине:";
$absdashboardtext["rent_type"]                   = "Аренда";
$absdashboardtext["rent_type_nights"]            = "Ночей";
$absdashboardtext["rent_type_days"]              = "Дней";
$absdashboardtext["country_vat"]                 = "Ваш НДС или НТУ";
$absdashboardtext["vat_or_gst"]                  = "НДС или НТУ";
$absdashboardtext['vat_or_gst_included']         = "НДС или НТУ";
$absdashboardtext['vat_or_gst_included_yes']     = 'включено в цену';
$absdashboardtext['vat_or_gst_included_no']      = 'не входит в стоимость';
$absdashboardtext["error_cover_size"]            = "Фотография обложки должна иметь не менее 1024 пикселей в ширину и 685 пикселей в высоту";
$absdashboardtext["error_cover_extensions"]      = "Фотография обложки должна иметь следующий формат: JPEG/JPG/PNG";
$absdashboardtext["error_cover_file_size"]       = "Фотография обложки должна весить не более 500 Кб";
$absdashboardtext['space_type_hotel']            = 'Гостиница';
$absdashboardtext['space_type_house']            = 'жилой дом';
$absdashboardtext['space_type_apartment']        = 'квартира';
$absdashboardtext['space_type_events_room']      = 'Конференц-зал';
$absdashboardtext['space_type_office']           = 'офис';
$absdashboardtext['space_type_motel']            = 'мотель';
$absdashboardtext['space_type_pension']          = 'пенсия';
$absdashboardtext['space_type_holiday_home']     = 'Дом отдыха';
$absdashboardtext['space_type_guest_house']      = 'Гостевой дом';
$absdashboardtext['space_type_bed_and_breakfast']= 'Кровать и завтрак';
$absdashboardtext['space_type_country_house']    = 'Деревенский дом';
$absdashboardtext['space_type_villa']            = 'Вилла';
$absdashboardtext['space_type_hostel']           = 'Общежитие';
$absdashboardtext['space_selected_all']          = 'Все пробелы';
$absdashboardtext['space_selected_all_rooms']    = 'Все номера';



// No Access
$absdashboardtext["no_access"]               = "К сожалению, у вас нет прав для просмотра данной страницы.";

// Registration
$absdashboardtext["username"]                = "Имя пользователя";
$absdashboardtext["password"]                = "Пароль";
$absdashboardtext["re_password"]             = "Подтверждение пароля";
$absdashboardtext["registration"]            = "Информация учетной записи";
$absdashboardtext["contact_info"]            = "Контактная информация";
$absdashboardtext["register_next"]           = "ДАЛЕЕ";
$absdashboardtext["create_account"]          = "РЕГИСТРАЦИЯ";
$absdashboardtext["fullname"]                = "Полное имя";
$absdashboardtext["company"]                 = "Компания";
$absdashboardtext['vat_number']              = 'VAT number';
$absdashboardtext['payout']                  = 'Payout';
$absdashboardtext['paypal_iban']             = 'Paypal or IBAN/Number';
$absdashboardtext['paypal_iban_info']        = 'Write your paypal email address or IBAN/Account number to receive your money.';
$absdashboardtext["host_email_contact_info"] = "Данный электронный адрес будет отправлен гостю после завершения бронирования на случай возникновения проблем и вопросов о бронировании.";
$absdashboardtext["host_phone_contact_info"] = "Данный телефон будет отправлен гостю после завершения бронирования на случай возникновения проблем и вопросов о бронировании.";
$absdashboardtext["account_main_settings"]   = "Основные настройки учетной записи";
$absdashboardtext["register_error"]          = "К сожалению, подключение было нарушено. Пожалуйста, попробуйте позднее.";
$absdashboardtext["used_for_hint"]           = "Выбирайте проект Spaces, если вы хотите использовать учетную запись для ваших отелей, домов, квартир, залов, офисов, мотелей, пансионов, гостевых домов, апартаментов, загородных домов, вилл и хостелов.";
$absdashboardtext["website"]                 = "Сайт";
$absdashboardtext["website_hint"]            = "Укажите сайт, на котором вы используете приложение, или оставьте поле пустым, если вы используете Facebook";
$absdashboardtext["used_for_spaces"]         = "Spaces";
$absdashboardtext["used_for"]                = "Используется для";
$absdashboardtext["country"]                 = "Страна";
$absdashboardtext["state"]                   = "Регион";
$absdashboardtext["pro_account"]             = "Подписка PRO";
$absdashboardtext["pro_account_monthly"]     = "Ежемесячная подписка";
$absdashboardtext["pro_account_total"]       = "Итого";

// Website Homepage
$absdashboardtext['website_homepage_subtitle']                           = 'Ознакомьтесь с самыми последними статьями в нашем блоге.';
$absdashboardtext['website_homepage_widget_subtitle']                    = 'Узнайте о том, как портал book.eu.com может помочь вам найти ответы на все вопросы.';
$absdashboardtext['website_homepage_spotlights_value_0_title']           = 'Поиск';
$absdashboardtext['website_homepage_spotlights_value_0_desc']            = 'Используйте поиск по нашей обширной базой данных, и найдите лучшее место для вашего отдыха.';
$absdashboardtext['website_homepage_spotlights_value_1_title']           = 'Выбрать';
$absdashboardtext['website_homepage_spotlights_value_1_desc']            = 'Выбирайте отели, виллы и квартиры, которые полностью отвечают вашим запросам и требованиям.';
$absdashboardtext['website_homepage_spotlights_value_2_title']           = 'Быстрое бронирование';
$absdashboardtext['website_homepage_spotlights_value_2_desc']            = 'Вы сможете забронировать понравившийся вам объект, не тратя время на длительную регистрацию.';

$absdashboardtext['register_error_website']                              = 'There was an error registering, we will redirect you to our website. You can create an account directly through our website.';
$absdashboardtext['demo_booking_calendar']                               = 'Демо - Календарь бронирования';

// Extensions
$absdashboardtext['extensions']                                          = 'Extensions';
$absdashboardtext['search_extension']                                    = 'Search extension';
$absdashboardtext['extension_install']                                   = 'Install';
$absdashboardtext['extension_activate']                                  = 'Activate';
$absdashboardtext['extension_deactivate']                                = 'Deactivate';