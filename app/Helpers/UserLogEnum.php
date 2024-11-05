<?php
namespace App\Helpers;
enum UserLogEnum: string
{

    case REGISTER_SUCCESS = "Kayit Olundu";
    case REGISTER_FAIL = "Kayit Basarisiz";
    case LOGIN_ADMIN= "Admin Girisi";
    case LOGIN_SUCCESS = "Giris Basarili";
    case LOGIN_FAIL = "Giris Basarisiz";
    case LOGOUT = "Cıkıs Yapıldı";

    case ARTICLE_ADD_SUCCESS = "Makale Eklendi";
    case ARTICLE_ADD_FAIL = "Makale Ekleme Basarisiz";

    case ARTICLE_UPDATE_SUCCESS = "Makale Guncellendi";

    case ARTICLE_UPDATE_FAIL = "Makale Guncelleme Basarisiz";

    case ARTICLE_DELETE_SUCCESS = "Makale Silindi";

    case ARTICLE_DELETE_FAIL = "Makale Silme Basarisiz";

    case ARTICLE_REPORT_SUCCESS = "Makale Sikayet Edildi";

    case ARTICLE_REPORT_FAIL = "Makale Sikayet Etme Basarisiz";
    case COMMENT_ADD_SUCCESS = "Yorum Eklendi, Onay Bekliyor";

    case COMMENT_ADD_FAIL = "Yorum Ekleme Basarisiz";
    case COMMENT_CONFIRM_SUCCESS = "Yorum Onaylandi";

    case COMMENT_CONFIRM_FAIL = "Yorum Onaylama Basarisiz";

    case COMMENT_REPORT_SUCCESS = "Yorum Sikayet Edildi";

    case COMMENT_REPORT_FAIL = "Yorum Sikayet Etme Basarisiz";

    case COMMENT_DELETE_SUCCESS = "Yorum Silindi";

    case COMMENT_DELETE_FAIL = "Yorum Silme Basarisiz";




}
