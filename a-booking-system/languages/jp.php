<?php
if (!defined('ABSPATH')) exit;

global $ABookingSystem;
global $absdashboardtext;


/*
 * English language file
 */

$absdashboardtext['title']                   = 'A+ Booking System';
$absdashboardtext['service']                 = 'Book Everything Unlimited';
$absdashboardtext["connection"]              = "接続";
$absdashboardtext["connect_to"]              = "に接続します";
$absdashboardtext["connected_to"]            = "に接続されています";
$absdashboardtext['i_m_agree']               = '<a target=\'blank\' href=\''.$ABookingSystem['terms_and_conditions'].'\'>私は、利用規約に同意します</a>';
$absdashboardtext["must_agree"]              = "あなたは私たちのサービスを利用するための契約条件に同意する必要があります";
$absdashboardtext["calendars"]               = "カレンダー";
$absdashboardtext["reservations"]            = "予約";
$absdashboardtext["network"]                 = "ネットワーク";
$absdashboardtext["my_account"]              = "マイアカウント";
$absdashboardtext["support"]                 = "サポート";
$absdashboardtext["listings"]                = "リスト";
$absdashboardtext['connect_video']           = 'Once you\'ve created your account, you can follow the steps in this <a target=\'blank\' href=\''.$ABookingSystem['how_to_connect_video'].'\'>video</a> to connect.';
$absdashboardtext['get_key_info']            = 'Get Key<i>Once you\'ve created your account go to book.eu.com and sign in. Then go to \'My Account\' and copy \'User Key\'.</i>';

$absdashboardtext["delete_button"]           = "削除";
$absdashboardtext["reject_button"]           = "拒絶します";
$absdashboardtext["approve_button"]          = "認めます";
$absdashboardtext["get_code"]                = "シェア";
$absdashboardtext["calendar"]                = "カレンダー";
$absdashboardtext["group"]                   = "グループ";
$absdashboardtext["my_calendars"]            = "私のカレンダー";
$absdashboardtext['more_prices']             = 'More prices';


// Loader
$absdashboardtext["loading"]                 = "読み込んでいます....";
$absdashboardtext["wait"]                    = "...すぐに完了します。お待ちください...";
$absdashboardtext["completed"]               = "完成しました";
$absdashboardtext["refresh"]                 = "しばらくお待ちください...更新されます...";
$absdashboardtext["saved"]                   = "保存された";
$absdashboardtext["save_success"]            = "データが正常に保存されています...";
$absdashboardtext["delete"]                  = "あなたはそれを削除しますか？";
$absdashboardtext["reject"]                  = "あなたはそれを拒否しますか？";
$absdashboardtext["deleted"]                 = "カレンダー/グループは正常に削除されています...";
$absdashboardtext["rejected"]                = "カレンダー/グループは、正常に拒否されています...";
$absdashboardtext["share"]                   = "このカレンダーを共有します";
$absdashboardtext["share_on"]                = "上の共有";
$absdashboardtext["share_fb_link"]           = "Facebookのリンク";
$absdashboardtext['share_fb_text']           = 'あなたはすでにFacebookのビジネスページを持っている場合は、単に `<i>'.$absdashboardtext['share_fb_link'].'</i>`をコピーして、ここからの指示に従ってください <a href=\''.$ABookingSystem['share_fb_link_video'].'\' target=\'_blank\'>ビデオ</a>. それ以外の場合はFacebookのビジネスページを作成してください <a href=\''.$ABookingSystem['share_fb_link_create_business'].'\' target=\'_blank\'>ここに</a>';
$absdashboardtext["share_website"]           = "ウェブサイトのタイプ ";
$absdashboardtext["share_wordpress"]         = "ショートコード ";
$absdashboardtext['share_wordpress_text']    = 'あなたは既に私たちのワードプレスのプラグインをインストールしている場合は、単に `Shortcode`をコピーして、ここからの指示に従ってください <a href=\''.$ABookingSystem['share_wp_link_video'].'\' target=\'_blank\'>ビデオ</a>. エルスからあなたのワードプレスのプラグインをインストールしてください <a href=\''.$ABookingSystem['share_wp_link_download'].'\' target=\'_blank\'>ここに</a>';
$absdashboardtext['share_wix']               = 'Wixのリンク';
$absdashboardtext['share_wix_text']          = 'あなたはすでにWixページを持っている場合は、単に `<i>'.$absdashboardtext['share_wix'].'</i>`をコピーして、ここからの指示に従ってください <a href=\''.$ABookingSystem['share_wix_link_video'].'\' target=\'_blank\'>ビデオ</a>. それ以外の場合はWixページを作成してください <a href=\''.$ABookingSystem['share_wix_link_create_wix_website'].'\' target=\'_blank\'>ここに</a>';
$absdashboardtext['share_weebly']               = 'Weebly iFrame';
$absdashboardtext['share_weebly_text']          = 'あなたはすでにWeeblyページを持っている場合は、単に `<i>'.$absdashboardtext['share_weebly'].'</i>`をコピーして、ここからの指示に従ってください <a href=\''.$ABookingSystem['share_weebly_link_video'].'\' target=\'_blank\'>ビデオ</a>. それ以外の場合はWeeblyページを作成してください <a href=\''.$ABookingSystem['share_weebly_link_create_weebly_website'].'\' target=\'_blank\'>ここに</a>';
$absdashboardtext["share_other_files"]       = "私たちの図書館 ";
$absdashboardtext["share_other_short"]       = "ショートコード ";
$absdashboardtext['share_other_text']        = '1 - 「ライブラリ」をコピーして、サイトの見出しの内側に追加します。<br>2 - 次に `Shortcode`をコピーして、サイトタグに挿入します。<br>3サイトを「中間設定 - >許可サイト」に追加します。 <br>この<a href=\''.$ABookingSystem['share_other_link_video'].'\' target=\'_blank\'>ビデオ</a> の指示に従って、操作方法を確認してください';


// Info
$absdashboardtext["disconnect"]              = "接続を解除してもよろしいですか？";
$absdashboardtext["no_dashboard"]            = "ダッシュボードを使用することはできません...";
$absdashboardtext["button_yes"]              = "はい、同意します";
$absdashboardtext["button_no"]               = "いいえ、キャンセル...";


// Warning
$absdashboardtext["warning"]                 = "警告！";
$absdashboardtext["warning_error"]           = "間違った身分証明書...それらを確認してからもう一度やり直してください";
$absdashboardtext["warning_contact"]         = "Book Everything Unlimitedサポートにお問い合わせください";
$absdashboardtext["warning_delete"]          = "Ups ...何かが間違っていた、後でやり直してください。";
$absdashboardtext["warning_overbooking"]     = "アップス...%sは選択した期間利用できません。";


// New Calendar
$absdashboardtext["new_calendar"]                = "新しいカレンダー";
$absdashboardtext["new_group"]                   = "新しいグループ";
$absdashboardtext["calendar_name"]               = "名前";
$absdashboardtext["website_name"]                = "ウェブサイト";
$absdashboardtext["calendar_location"]           = "配置";
$absdashboardtext["your_calendar_location"]      = "あなたのカレンダー...";
$absdashboardtext["calendar_address"]            = "完全な住所";
$absdashboardtext["currency"]                    = "通貨";
$absdashboardtext["category"]                    = "カテゴリ";
$absdashboardtext["calendar_type"]               = "カレンダーの種類";
$absdashboardtext["calendar_type_days"]          = "日";
$absdashboardtext["calendar_type_hours"]         = "日と時間";
$absdashboardtext["reservations_type"]           = "予約タイプ";
$absdashboardtext["reservations_type_free"]      = "自由な";
$absdashboardtext["reservations_type_paid"]      = "支払いました";
$absdashboardtext["description"]                 = "説明";
$absdashboardtext["my_calendar"]                 = "カレンダー分";
$absdashboardtext["my_group"]                    = "私のグループ";
$absdashboardtext["optional"]                    = "オプショナル";
$absdashboardtext["create_calendar"]             = "カレンダーを作成します";
$absdashboardtext["create_group"]                = "ラググループ";
$absdashboardtext["cancel"]                      = "キャンセル";
$absdashboardtext["yes"]                         = "JA";
$absdashboardtext["no"]                          = "NEI";
$absdashboardtext["calendars_limit_reached"]     = "カレンダーの制限に達しました。 %sカレンダーは追加できません。";
$absdashboardtext["calendars_upgrade_account"]   = "カレンダーを追加するには、アカウントをプロにアップグレードします。";
$absdashboardtext["groups_limit_reached"]        = "あなたはグループの制限に達しました。 %s個以上のグループを追加することはできません。";
$absdashboardtext["groups_upgrade_account"]      = "グループを追加するには、アカウントをプロにアップグレードします。";
$absdashboardtext["calendars_add_calendar"]      = "カレンダー";
$absdashboardtext["calendars_calendar_type"]     = "カテゴリ";
$absdashboardtext["calendars_rules"]             = "カレンダーの規則";
$absdashboardtext["calendars_allowed"]           = "許可されたサイト";


// Settings
$absdashboardtext["availability_price"]      = "在庫状況と価格";
$absdashboardtext["availability"]            = "可用性";
$absdashboardtext["settings"]                = "設定";
$absdashboardtext["form"]                    = "フォーム";
$absdashboardtext["notifications"]           = "通知";
$absdashboardtext["sync"]                    = "同期";
$absdashboardtext["sync_settings"]           = "同期設定 - iCalリンク";
$absdashboardtext["sync_my_settings"]        = "同期設定 - マイiCalリンク";
$absdashboardtext["sync_airbnb"]             = "airbnb";
$absdashboardtext["sync_booking_com"]        = "Booking.com";
$absdashboardtext["sync_google_calendar"]    = "グーグル";
$absdashboardtext["sync_homeaway_com"]       = "ホームアウェイ";
$absdashboardtext["sync_homestay_com"]       = "ホームステイ";
$absdashboardtext["sync_vrbo_com"]           = "VRBO";
$absdashboardtext["sync_flipkey_com"]        = "旅行ガイドなど";
$absdashboardtext["sync_other_calendar"]     = "他の";

$absdashboardtext["default_settings"]            = "不履行";
$absdashboardtext["advanced_settings"]           = "高度";
$absdashboardtext["save"]                        = "保存";
$absdashboardtext["hint"]                        = "ヒント！";
$absdashboardtext["day_hours_available"]         = "利用可能なアイテムの数。 1より大きいか等しい必要があります";
$absdashboardtext["day_hours_booked"]            = "予約されたアイテムの数。";
$absdashboardtext["yearly"]                      = "毎年";
$absdashboardtext["weekaday"]                    = "Weekaday";
$absdashboardtext["monthly"]                     = "毎月";
$absdashboardtext["weeks"]                       = "週間";
$absdashboardtext["custom_date"]                 = "カスタマイズされた期間";
$absdashboardtext["period"]                      = "期間";
$absdashboardtext["main_settings"]               = "メイン設定";
$absdashboardtext["cancellation_settings"]       = "取り消し";
$absdashboardtext["cancellation_allowed"]        = "許容";
$absdashboardtext["cancellation_no"]             = "ノー";
$absdashboardtext["cancellation_before_day"]     = "1日前";
$absdashboardtext["cancellation_before_days"]    = "%s日前";
$absdashboardtext["cancellation_before_week"]    = "1週間前";
$absdashboardtext["cancellation_before_weeks"]   = "%s週間前";
$absdashboardtext["cancellation_before_month"]   = "1ヶ月前";
$absdashboardtext["cancellation_before_months"]  = "%sヶ月前";
$absdashboardtext["cancellation_refund"]         = "払い戻し";
$absdashboardtext["cancellation_refund_info"]    = "払い戻し額の割合（0-100）。サービス料は含まれていません。";
$absdashboardtext["rules_settings"]              = "ルール";

// Availability
$absdashboardtext["status"]                      = "ステータス";
$absdashboardtext["status_available"]            = "利用できます";
$absdashboardtext["status_unavailable"]          = "無効";
$absdashboardtext["status_booked"]               = "予約";
$absdashboardtext["prices"]                      = "物価";
$absdashboardtext["price"]                       = "日々";
$absdashboardtext["monthly_price"]               = "毎月";
$absdashboardtext["weekly_price"]                = "ウィークリー";
$absdashboardtext["weekend_price"]               = "週末";
$absdashboardtext["notes"]                       = "備考";
$absdashboardtext["notes_write"]                 = "ここにメモを書いてください。";
$absdashboardtext["your_price"]                  = "あなたの価格";
$absdashboardtext["service_fee"]                 = "サービス料";
$absdashboardtext["final_price"]                 = "最新価格";
$absdashboardtext['estimated_price']             = '見積価格';
$absdashboardtext['estimated_price_info']        = 'The price may be different because our service fee depends on the total amount. (Our percentage for the service fee is lower when the amount increases). The final price will also include the payment processing fee (Paypal fee). If the reservation is made from the affiliate site it will include the affiliate fee also.';
$absdashboardtext['service_fee_info']            = 'This helps us run and develop our booking services and offer fast support. It includes VAT/GST.';
$absdashboardtext["year"]                        = "年";
$absdashboardtext["week"]                        = "週";
$absdashboardtext["availability_warning_head"]   = "あなたの部屋の各部屋にこれを保存しますか？";
$absdashboardtext["availability_warning"]        = "これをやりたいですか？ 1室のみの場合は、まず部屋を選択してください。";

// Form
$absdashboardtext["email"]               = "メール";
$absdashboardtext["phone"]               = "電話";
$absdashboardtext["via_email"]           = "メールで";
$absdashboardtext["via_sms"]             = "SMS経由で";
$absdashboardtext["form_use"]            = "使用";
$absdashboardtext["form_required"]       = "しなければなりません";
$absdashboardtext["for_host"]            = "ホスト用";
$absdashboardtext["for_guest"]           = "ゲスト用";
$absdashboardtext["via_email_host"]      = "メールで";
$absdashboardtext["via_sms_host"]        = "SMS経由で";
$absdashboardtext["via_email_guest"]     = "メールで";
$absdashboardtext["via_sms_guest"]       = "SMS経由で";
$absdashboardtext["send"]                = "送ります";
$absdashboardtext["sender"]              = "送信者";
$absdashboardtext["language"]            = "言語";
$absdashboardtext["message"]             = "メッセージ";
$absdashboardtext["autodetect"]          = "自動検出";
$absdashboardtext["the_field"]           = "フィールド";
$absdashboardtext["already_exist"]       = "すでにデータベースに存在しています。";
$absdashboardtext["the_fields"]          = "地球";
$absdashboardtext["and"]                 = "と";
$absdashboardtext["must_be_identique"]   = "同一でなければなりません。";

// Week Days
$absdashboardtext["weekday"]     = "平日";
$absdashboardtext["monday"]      = "月曜日";
$absdashboardtext["tuesday"]     = "火曜日";
$absdashboardtext["wednesday"]   = "水曜日";
$absdashboardtext["thursday"]    = "木曜日";
$absdashboardtext["friday"]      = "金曜日";
$absdashboardtext["saturday"]    = "土曜日";
$absdashboardtext["sunday"]      = "日曜日";

// Months
$absdashboardtext["month"]       = "月";
$absdashboardtext["january"]     = "1月";
$absdashboardtext["february"]    = "二月";
$absdashboardtext["march"]       = "三月";
$absdashboardtext["april"]       = "四月";
$absdashboardtext["may"]         = "かもしれません";
$absdashboardtext["june"]        = "六月";
$absdashboardtext["july"]        = "七月";
$absdashboardtext["august"]      = "八月";
$absdashboardtext["september"]   = "九月";
$absdashboardtext["october"]     = "十月";
$absdashboardtext["november"]    = "十一月";
$absdashboardtext["december"]    = "12月";
$absdashboardtext['today']       = '今日';
$absdashboardtext['list']        = 'リスト';
$absdashboardtext['more']        = 'もっと見る';


// Errors
$absdashboardtext["error_is_required"]           = "このフィールドをチェックしてください！";
$absdashboardtext["error_is_email"]              = "間違った電子メールアドレス！";
$absdashboardtext["error_is_phone"]              = "間違った電話番号！";
$absdashboardtext["error_is_iban"]               = "間違った銀行IBAN！";
$absdashboardtext["error_is_swift"]              = "間違った銀行の高速コード！";
$absdashboardtext["error_is_lower_than"]         = "%s以下でなければなりません！";
$absdashboardtext["error_is_higher_than"]        = "%s以上である必要があります！";
$absdashboardtext["error_invalid_url"]           = "間違ったウェブサイト！";
$absdashboardtext["error_min_chars"]             = "このフィールドには少なくとも%s個の文字が必要です。";
$absdashboardtext["error_allowed_characters"]    = "%s文字のみが許可されています！";

// Network - settings
$absdashboardtext["network_name"]                        = "ネットワークの名前";
$absdashboardtext["network_settings"]                    = "設定";
$absdashboardtext["network_payments"]                    = "決済システム";
$absdashboardtext["commission"]                          = "コミッション";
$absdashboardtext["commission_type"]                     = "コミッションタイプ";
$absdashboardtext["commission_type_fixed"]               = "ファーム";
$absdashboardtext["commission_type_percent"]             = "パーセント";
$absdashboardtext["roles_for_owners"]                    = "所有者の役割";
$absdashboardtext["roles_for_owners_info"]               = "所有者の役割を入力します（コンマで区切ります）";
$absdashboardtext["roles_for_customers"]                 = "顧客の役割";
$absdashboardtext["roles_for_customers_info"]            = "顧客のロールを入力します（カンマで区切ります）。";
$absdashboardtext["allow_guests_to_book"]                = "ゲストは予約可能です";
$absdashboardtext["allow_guests_to_book_info"]           = "ゲストに注文を許可する";
$absdashboardtext["use_settings"]                        = "設定を使用する";
$absdashboardtext["use_settings_info"]                   = "所有者はカレンダー設定を使用できます";
$absdashboardtext["use_form_settings"]                   = "フォーム設定を使用する";
$absdashboardtext["use_form_settings_info"]              = "所有者はカレンダーフォームの設定を使用できます";
$absdashboardtext["use_notifications"]                   = "メッセージ設定を使用する";
$absdashboardtext["use_notifications_info"]              = "所有者はカレンダーアラート設定を使用できます";
$absdashboardtext["use_sync"]                            = "同期を使用する";
$absdashboardtext["use_sync_info"]                       = "所有者はカレンダー同期を使用できます";
$absdashboardtext["add_calendar"]                        = "カレンダー/グループを追加";
$absdashboardtext["add_calendar_info"]                   = "所有者はカレンダー/グループを作成できます";
$absdashboardtext["delete_calendar"]                     = "カレンダー/グループの削除";
$absdashboardtext["delete_calendar_info"]                = "オーナーは自分のカレンダー/グループを削除できます";
$absdashboardtext["create_at_register"]                  = "各ユーザーのカレンダー";
$absdashboardtext["create_at_register_info"]             = "ユーザー登録のためのカレンダーを自動作成し、作成したユーザーに割り当てます。";
$absdashboardtext["create_for_post"]                     = "各投稿のカレンダー";
$absdashboardtext["create_for_post_info"]                = "投稿を作成するときにカレンダーを自動作成し、作成したユーザーに割り当てます。";
$absdashboardtext["create_for_custom_post"]              = "各カスタム投稿のカレンダー";
$absdashboardtext["create_for_custom_post_info"]         = "カスタム投稿を作成してカレンダーを自動作成し、作成したユーザーに割り当てます。";
$absdashboardtext["create_for_custom_post_name"]         = "カスタム姓";
$absdashboardtext["create_for_custom_post_name_info"]    = "カスタム投稿を作成するときにカレンダーを自動実行します。";
$absdashboardtext["max_calendars"]                       = "最大カレンダー";
$absdashboardtext["max_calendars_info"]                  = "ユーザーあたりのカレンダーの最大数。無制限の場合は0です。";
$absdashboardtext["default_reservations_type"]           = "標準カレンダー予約タイプ";
$absdashboardtext["default_calendar_type"]               = "デフォルトカレンダータイプ";
$absdashboardtext["default_category"]                    = "標準カテゴリ";
$absdashboardtext["default_currency"]                    = "標準通貨";

// Network - payment systems
$absdashboardtext["use_stripe"]                          = "ストリップを使用する";
$absdashboardtext["use_stripe_info"]                     = "ストリップペイメントシステムを有効/無効にする";
$absdashboardtext["stripe_secret_key"]                   = "ストライプ秘密鍵";
$absdashboardtext["stripe_secret_key_info"]              = "ストリップの秘密鍵を書く";
$absdashboardtext["stripe_publishable_key"]              = "ストライプ公開可能キー";
$absdashboardtext["stripe_publishable_key_info"]         = "ストリップパブリッシュ可能なキーを作成します。";
$absdashboardtext["use_test_stripe"]                     = "テストのためにストリップを使用する";
$absdashboardtext["use_test_stripe_info"]                = "テスト用のストリップペイメントシステムの有効化/無効化";
$absdashboardtext["stripe_test_secret_key"]              = "ストライプテスト秘密鍵";
$absdashboardtext["stripe_test_secret_key_info"]         = "テストのためにあなたのストリップ秘密鍵を書いてください";
$absdashboardtext["stripe_test_publishable_key"]         = "ストライプテストパブリッシュ可能なキー";
$absdashboardtext["stripe_test_publishable_key_info"]    = "テスト用にパブリッシュ可能なストリップを作成します。";

// Reservations
$absdashboardtext["reservations_for"]                    = "ご予約";
$absdashboardtext["reservations_contact"]                = "接触";
$absdashboardtext["reservations_email"]                  = "メール";
$absdashboardtext["reservations_phone"]                  = "電話";
$absdashboardtext["reservations_start_date"]             = "チェック";
$absdashboardtext["reservations_end_date"]               = "チェックアウト";
$absdashboardtext["reservations_day_included"]           = "含めて";
$absdashboardtext["reservations_owner_price"]            = "所有者の価格";
$absdashboardtext["reservations_your_price"]             = "あなたの価格";
$absdashboardtext["reservations_just_price"]             = "価格";
$absdashboardtext["reservations_service_fee"]            = "サービス料";
$absdashboardtext["reservations_network_fee"]            = "ネットワーク料";
$absdashboardtext["reservations_total_price"]            = "合計価格";
$absdashboardtext["reservations_no_items"]               = "アイテム";
$absdashboardtext["reservations_add"]                    = "予約を追加する";
$absdashboardtext["reservations_add_details"]            = "予約の詳細";
$absdashboardtext["reservations_add_check_in"]           = "チェック";
$absdashboardtext["reservations_add_check_out"]          = "チェックアウト";
$absdashboardtext["reservations_adding"]                 = "予約を保存する";
$absdashboardtext["reservations_from"]                   = "からの予約";
$absdashboardtext["reservations_from_admin"]             = "ホスト";
$absdashboardtext["reservations_from_calendar"]          = "ゲスト";
$absdashboardtext["reservations_from_booking_com"]       = "Booking.com";
$absdashboardtext["reservations_from_airbnb_com"]        = "Airbnb.com";
$absdashboardtext["reservations_from_google_calendar"]   = "Googleカレンダー";
$absdashboardtext["reservations_from_homeaway_com"]      = "Homeaway.com";
$absdashboardtext["reservations_from_homestay_com"]      = "Homestay.com";
$absdashboardtext["reservations_from_vrbo_com"]          = "VRBO.com";
$absdashboardtext["reservations_from_flipkey_com"]       = "Flipkey.com";
$absdashboardtext["reservations_from_other_calendar"]    = "その他のカレンダー";
$absdashboardtext["reservation_cancel_question"]         = "予約をキャンセルしてもよろしいですか？";
$absdashboardtext["reservation_cancel_message"]          = "キャンセルする場合は、$%sが返されます";
$absdashboardtext["reservation_cancel_warning"]          = "予約は存在しないか、既にキャンセルされているか、またはキャンセル期間が終了しています。";
$absdashboardtext["reservation_cancel_success"]          = "予約はキャンセルされます。";
$absdashboardtext["reservation_cancel_error"]            = "予約はキャンセルできません。後でもう一度お試しください。";
$absdashboardtext["reservations_cancel_btn"]             = "予約をキャンセルする";
$absdashboardtext["reservations_cancel_txt"]             = "予約をキャンセルしますか？";
$absdashboardtext["reservations_cancel_reason"]          = "理由";

// My Account
$absdashboardtext["my_withdraws"]                        = "私の引き出し";
$absdashboardtext["withdraw"]                            = "撤退";
$absdashboardtext["search_payment"]                      = "支払いを申請する";
$absdashboardtext["withdraw_name"]                       = "氏名";
$absdashboardtext["withdraw_company"]                    = "パーティー";
$absdashboardtext["withdraw_bank_name"]                  = "銀行名";
$absdashboardtext["withdraw_bank_iban"]                  = "銀行IBAN";
$absdashboardtext["withdraw_bank_swift"]                 = "すぐに銀行化する";
$absdashboardtext["withdraw_amount"]                     = "金額";
$absdashboardtext["new_withdraw"]                        = "撤退";
$absdashboardtext["create_withdraw"]                     = "提出";
$absdashboardtext["minimum_payout"]                      = "不十分な資金。最低引き出し額は$ 50です。";
$absdashboardtext["money"]                               = "お金";
$absdashboardtext["money_earnings"]                      = "あなたのポケットに";
$absdashboardtext['money_paid']                          = 'Received';
$absdashboardtext["my_account_reservations"]             = "予約";
$absdashboardtext["my_account_reservations_upcoming"]    = "来たる";
$absdashboardtext["my_account_reservations_past"]        = "過去";
$absdashboardtext["my_account_requests"]                 = "リクエスト";
$absdashboardtext["my_account_api_details"]              = "API";
$absdashboardtext["my_account_api_user_key"]             = "ユーザーキー";
$absdashboardtext["my_account_api_endpoint"]             = "エンドポイント";
$absdashboardtext["my_account_requests_calendar"]        = "カレンダー";
$absdashboardtext["my_account_requests_dashboard"]       = "計器盤";
$absdashboardtext["my_account_withdraw_status"]          = "支払い状況";
$absdashboardtext['my_account_withdraw_status_paid']     = 'Paid';
$absdashboardtext['my_account_withdraw_status_unpaid']   = 'Unpaid';
$absdashboardtext['my_account_withdraw_status_rejected'] = 'Rejected';
$absdashboardtext['my_account_withdraw_pay_date']        = 'Pay date';



// Statement
$absdashboardtext["statement"]                       = "声明";
$absdashboardtext["statements"]                      = "ステートメント";
$absdashboardtext["statement_my_funds"]              = "私の手段";
$absdashboardtext["statement_earnings"]              = "収入";
$absdashboardtext["statement_vat"]                   = "VAT";
$absdashboardtext["statement_fees"]                  = "手数料";
$absdashboardtext["statement_text"]                  = "過去30日間の注文と紹介収入";
$absdashboardtext["statement_date"]                  = "日付";
$absdashboardtext["statement_oder_id"]               = "注文ID";
$absdashboardtext["statement_type"]                  = "タイプ";
$absdashboardtext["statement_host_referral"]         = "ホスト紹介料";
$absdashboardtext["statement_guest_referral"]        = "ゲスト紹介料";
$absdashboardtext["statement_service_fee"]           = "サービス料";
$absdashboardtext["statement_payment_fee"]           = "支払手数料";
$absdashboardtext["statement_refund"]                = "払い戻し";
$absdashboardtext['statement_exchange']              = '交換';
$absdashboardtext['statement_service_fee_for']       = "へ"; // Service Fee for INV 09344
$absdashboardtext["statement_booking"]               = "予約";
$absdashboardtext["statement_invoice"]               = "請求";
$absdashboardtext["statement_price"]                 = "価格";
$absdashboardtext["statement_detail"]                = "ディテール";
$absdashboardtext["statement_amount"]                = "金額";
$absdashboardtext["statement_view_invoices"]         = "請求書を見る";
$absdashboardtext["statement_invoice_no"]            = "請求番号";
$absdashboardtext["statement_invoice_date"]          = "請求書の日付";
$absdashboardtext["statement_invoice_from"]          = "から";
$absdashboardtext["statement_invoice_to"]            = "へ";
$absdashboardtext["statement_bookings"]              = "受注";
$absdashboardtext["statement_rate"]                  = "賭けます";
$absdashboardtext["statement_invoice_total"]         = "請求書合計";
$absdashboardtext["statement_invoice_description"]   = "この請求書に記載されている金額はすべて米ドルです。表示されている注文の合計数は、注文から払い戻しまたは払い戻しを差し引いたものです。";



// Support
$absdashboardtext["my_tickets"]              = "私のチケット";
$absdashboardtext["ticket"]                  = "チケット";
$absdashboardtext["ticket_subject"]          = "主題";
$absdashboardtext["ticket_problem"]          = "問題";
$absdashboardtext["new_ticket"]              = "新しいチケット";
$absdashboardtext["create_ticket"]           = "チケットを作成する";
$absdashboardtext["status_unanswered"]       = "行方不明";
$absdashboardtext["status_answered"]         = "応答されたチケット";
$absdashboardtext["status_resolved"]         = "チケットを解決しました";
$absdashboardtext["working_hours"]           = "オフィス・アワー";
$absdashboardtext["monday_saturday"]         = "月曜日-土曜日";
$absdashboardtext["active_hours"]            = "09:00 - 17:00";
$absdashboardtext["your_reply"]              = "あなたの答え";
$absdashboardtext["reply_message"]           = "メッセージ";
$absdashboardtext["reply_message_required"]  = "あなたはメッセージボックスを記入する必要があります！";
$absdashboardtext["reply_message_hint"]      = "あなたのメッセージ";
$absdashboardtext["status_unsolved"]         = "プロセス中";
$absdashboardtext["status_solved"]           = "解決済み";
$absdashboardtext["status_not_possible_yet"] = "まだ利用できません";
$absdashboardtext["status_not_answered"]     = "答えられていない";
$absdashboardtext["close_ticket"]            = "チケットを閉じる";
$absdashboardtext["open_ticket"]             = "チケットを開く";
$absdashboardtext["search_ticket"]           = "検索チケット";

// Listings
$absdashboardtext["search_listing"]          = "検索エントリ";
$absdashboardtext["search_listing_rules"]    = "ルール";
$absdashboardtext["search_listing_filters"]  = "施設";
$absdashboardtext["search_listing_reason"]   = "理由";

// Custom account
$absdashboardtext["my_spaces"]                   = "私の部屋";
$absdashboardtext["spaces"]                      = "スペース";
$absdashboardtext["space"]                       = "部屋";
$absdashboardtext["add_space"]                   = "あなたのスペースをここに追加してください";
$absdashboardtext["add_space_in_content"]        = "スペースを追加する";
$absdashboardtext["add_space_add"]               = "追加";
$absdashboardtext["space_what_you_rent"]         = "あなたは何を借りたいですか？";
$absdashboardtext["space_next"]                  = "次";
$absdashboardtext["space_rent_rooms"]            = "あなたの部屋の部屋";
$absdashboardtext["space_rent_entire_space"]     = "全体のおしっこ";
$absdashboardtext["search_for_spaces"]           = "スペースを検索する...";
$absdashboardtext["search_for_events"]           = "検索イベント...";
$absdashboardtext["search_for_calendars"]        = "検索グループ/カレンダー...";
$absdashboardtext["space_details"]               = "細部";
$absdashboardtext["space_name"]                  = "ルーム名";
$absdashboardtext["space_cover"]                 = "表紙画像";
$absdashboardtext["space_cover_info"]            = "カバーイメージがプレゼンテーションページに追加されます";
$absdashboardtext["space_description"]           = "説明";
$absdashboardtext["space_description_hint"]      = "あなたの部屋についてのいくつかの言葉...";
$absdashboardtext["space_location"]              = "配置";
$absdashboardtext["space_address"]               = "完全な住所";
$absdashboardtext["space_type"]                  = "部屋タイプ";
$absdashboardtext["space_rooms"]                 = "部屋";
$absdashboardtext["space_add"]                   = "スペースを追加する";
$absdashboardtext["space_limit_reached"]         = "スペースの制限に達しました。 %s以上のスペースを追加することはできません。";
$absdashboardtext["space_upgrade_account"]       = "スペースを追加するには、アカウントをプロにアップグレードしてください。";
$absdashboardtext["space_rooms_limit_reached"]   = "あなたは部屋の限界に達しました。 %s以上の部屋を追加することはできません。";
$absdashboardtext["space_rooms_upgrade_account"] = "アカウントをプロにアップグレードして部屋を追加してください。";
$absdashboardtext["spaces_add_calendar"]         = "部屋";
$absdashboardtext["spaces_calendar_type"]        = "部屋タイプ";
$absdashboardtext["spaces_rules"]                = "部屋の方針";
$absdashboardtext["space_rooms_adding"]          = "部屋を追加";
$absdashboardtext["space_rooms_add"]             = "部屋を追加";
$absdashboardtext["space_price"]                 = "価格";
$absdashboardtext["space_check_in_time"]         = "チェック";
$absdashboardtext["space_check_out_time"]        = "チェックアウト";
$absdashboardtext["space_rejected"]              = "あなたの部屋は以下の理由で拒否されました：";
$absdashboardtext["rent_type"]                   = "家賃";
$absdashboardtext["rent_type_nights"]            = "ナイツ";
$absdashboardtext["rent_type_days"]              = "日";
$absdashboardtext["country_vat"]                 = "あなたのVATまたはGST。";
$absdashboardtext["vat_or_gst"]                  = "付加価値税/ GST";
$absdashboardtext['vat_or_gst_included']         = "付加価値税/ GST";
$absdashboardtext['vat_or_gst_included_yes']     = '価格に含まれる';
$absdashboardtext['vat_or_gst_included_no']      = '価格に含まれていない';
$absdashboardtext["error_cover_size"]            = "あなたの表紙の幅は1024px以上、高さは685px以上にする必要があります";
$absdashboardtext["error_cover_extensions"]      = "カバーはJPEG / JPG / PNGでなければなりません";
$absdashboardtext["error_cover_file_size"]       = "あなたのカバーは最大500 kBあります";
$absdashboardtext['space_type_hotel']            = 'ホテル';
$absdashboardtext['space_type_house']            = '家';
$absdashboardtext['space_type_apartment']        = 'アパート';
$absdashboardtext['space_type_events_room']      = 'イベントルーム';
$absdashboardtext['space_type_office']           = 'オフィス';
$absdashboardtext['space_type_motel']            = 'モーテル';
$absdashboardtext['space_type_pension']          = '年金';
$absdashboardtext['space_type_holiday_home']     = 'ホリデーホーム';
$absdashboardtext['space_type_guest_house']      = 'ゲストハウス';
$absdashboardtext['space_type_bed_and_breakfast']= 'ベッド＆ブレックファスト';
$absdashboardtext['space_type_country_house']    = 'カントリーハウス';
$absdashboardtext['space_type_villa']            = 'ヴィラ';
$absdashboardtext['space_type_hostel']           = 'ホステル';
$absdashboardtext['space_selected_all']          = 'すべてのスペース';
$absdashboardtext['space_selected_all_rooms']    = '全室';



// No Access
$absdashboardtext["no_access"]                           = "申し訳ありません。このページを表示する権限がありません。";

// Registration
$absdashboardtext["username"]                            = "ユーザー名";
$absdashboardtext["password"]                            = "パスワード";
$absdashboardtext["re_password"]                         = "パスワードを確認する";
$absdashboardtext["registration"]                        = "口座情報";
$absdashboardtext["contact_info"]                        = "接触";
$absdashboardtext["register_next"]                       = "次";
$absdashboardtext["create_account"]                      = "登録";
$absdashboardtext["fullname"]                            = "氏名";
$absdashboardtext["company"]                             = "パーティー";
$absdashboardtext['vat_number']                          = 'VAT number';
$absdashboardtext['payout']                              = 'Payout';
$absdashboardtext['paypal_iban']                         = 'Paypal or IBAN/Number';
$absdashboardtext['paypal_iban_info']                    = 'Write your paypal email address or IBAN/Account number to receive your money.';
$absdashboardtext["host_email_contact_info"]             = "これは、予約は、彼らが予約について質問がある場合は、必要にご連絡した場合に終了したときゲストに送信されますメールアドレスです";
$absdashboardtext["host_phone_contact_info"]             = "これは、予約は、彼らが予約について質問がある場合は、必要にご連絡した場合に終了したときゲストに送られる電話番号です";
$absdashboardtext["account_main_settings"]               = "アカウントメイン設定";
$absdashboardtext["register_error"]                      = "ごめんなさい ！ 接続が失われました。 後でもう一度お試しください。";
$absdashboardtext["used_for_hint"]                       = "あなたはホテル、住宅、アパート、イベントルーム、オフィス、モーテル、朝食、休日の家、ゲストハウス、ベッドと朝食のアカウントを使用したい場合はスペースを選択し、カントリーハウス、ヴィラ、ホステル";
$absdashboardtext["website"]                             = "ウェブサイト";
$absdashboardtext["website_hint"]                        = "あなたはFacebookを利用してそれを使用する場合、当社のアプリケーションを使用するか、空のままにしておきたいウェブサイト";
$absdashboardtext["used_for_spaces"]                     = "スペース";
$absdashboardtext["used_for"]                            = "使用する";
$absdashboardtext["country"]                             = "国";
$absdashboardtext["state"]                               = "州";
$absdashboardtext["pro_account"]                         = "プロアカウント";
$absdashboardtext["pro_account_monthly"]                 = "毎月の定期購読";
$absdashboardtext["pro_account_total"]                   = "トータル";

// Website Homepage
$absdashboardtext['website_homepage_subtitle']                           = '私たちのブログからの最新の記事を参照します。';
$absdashboardtext['website_homepage_widget_subtitle']                    = 'book.eu.comはあなたが必要なすべてを見つけるのを助けることができる方法を発見。';
$absdashboardtext['website_homepage_spotlights_value_0_title']           = 'サーチ';
$absdashboardtext['website_homepage_spotlights_value_0_desc']            = 'あなたのための最高の場所を検索し、私たちの広大なリストからフィルタ。';
$absdashboardtext['website_homepage_spotlights_value_1_title']           = '選択してください';
$absdashboardtext['website_homepage_spotlights_value_1_desc']            = 'ホテル/ヴィラ/アパート...あなたのニーズに、より良いフィットすることを選択してください。';
$absdashboardtext['website_homepage_spotlights_value_2_title']           = 'ファスト予約';
$absdashboardtext['website_homepage_spotlights_value_2_desc']            = 'アカウントを作成するハッスルなしにあなたが好きなものを予約するのは簡単。';

$absdashboardtext['register_error_website']                              = 'There was an error registering, we will redirect you to our website. You can create an account directly through our website.';
$absdashboardtext['demo_booking_calendar']                               = 'デモ-予約カレンダー';

// Extensions
$absdashboardtext['extensions']                                          = 'Extensions';
$absdashboardtext['search_extension']                                    = 'Search extension';
$absdashboardtext['extension_install']                                   = 'Install';
$absdashboardtext['extension_activate']                                  = 'Activate';
$absdashboardtext['extension_deactivate']                                = 'Deactivate';