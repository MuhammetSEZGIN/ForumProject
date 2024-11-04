<?php
namespace App\Helpers;
enum AdminMessageEnum: string{

    case VIEW_ALL_LOGS = "View All Logs";
    case VIEW_ALL_USERS = "View All Users";
    case USER_LOGS_DELETE_SUCCESS = "User Logs Delete Success";
    case USER_LOGS_DELETE_FAIL = "User Logs Delete Fail";
    case USER_LOGS_DELETE_ALL_SUCCESS = "User Logs Delete All Success";
    case USER_LOGS_DELETE_ALL_FAIL = "User Logs Delete All Fail";

    case USER_DELETE_SUCCESS = "User Delete Success";
    case USER_DELETE_FAIL = "User Delete Fail";

    case COMMENT_DELETE_SUCCESS = "Comment Delete Success";
    case COMMENT_DELETE_FAIL = "Comment Delete Fail";

    case ARTICLE_DELETE_SUCCESS = "Article Delete Success";
    case ARTICLE_DELETE_FAIL = "Article Delete Fail";

    case CATEGORY_ADD_SUCCESS = "Category Add Success";
    case CATEGORY_ADD_FAIL = "Category Add Fail";
    case CATEGORY_DELETE_FAIL = "Category Delete Fail";
    case CATEGORY_DELETE_SUCCESS = "Category Delete Success";


}
