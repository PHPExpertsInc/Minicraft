<?php

/*
 * %m1% and %m2% are dymamic markers which are replaced at run time by the relevant index.
 * They must not be edited.
 */

$lang = array();

// Not sorted yet
$lang = array_merge($lang, array(
  'EMAIL_CONFIRMATION_SUBJECT' => 'Activate your Account',
  'EMAIL_CONFIRMATION_BTN' => 'Activate',
  'EMAIL_CONFIRMATION_INSTRUCTIONS' => 'Click here to activate your account',
  'EMAIL_CONFIRMATION_HEADLINE' => 'One more step…',
  'EMAIL_RESET_SUBJECT' => 'Reset your Password',
  'EMAIL_RESET_INSTRUCTIONS' => 'Click here to reset your password',
  'EMAIL_RESET_INSTRUCTIONS_TXT' => 'Click here to reset your password',
  'EMAIL_RESET_HEADLINE' => 'One more step…',
  'EMAIL_RESET_BTN' => 'Reset',
  'INDEX' => 'Index',
  'FORUM' => 'Forum',
  'STORE' => 'Store',
  'BLOG' => 'Blog',
  'USERNAME' => 'Username',
  'TOGGLE_NAVIGATION' => 'Toggle navigation',
  'REGISTER' => 'Register',
  'LOGIN' => 'Sign in',
  'MY_ACCOUNT' => 'My Account',
  'PROFILE' => 'Profile',
  'LOGOUT' => 'Sign out',
  'SEARCH_PLAYER' => 'Search for a player',
  'PASSWORD' => 'Password',
  'EMAIL' => 'Email Address',
  'STAY_LOGGED_IN' => 'Stay signed in',
  'BTN_FORGOT_PASSWORD' => 'Forgot your Password?',
  'RESET_PASSWORD' => 'Reset your Password',
  'USERNAME_OR_EMAIL' => 'Username or Email Address',
  'PREVIOUS' => 'Previous',
  'NEXT' => 'Next',
  'BACK_TO_TOP' => 'Back to top',
  'VAULT' => 'Vault',
  'HOME' => 'Home',
  'TITLE' => 'Title',
  'EDIT' => 'Edit',
  'REMOVE' => 'Remove',
  'CATEGORY' => 'Category',
  'ADMIN_PANEL' => 'Administration Panel',
  'REMOVE_CONFIRMATION' => 'Are you sure you want to remove <strong>%m1%</strong>?',
  'THERE_ARE_ERRORS' => 'There are errors',
  'SHOW_MONEY' => 'You have %m1% %m2%',
  'USER_INFOS' => 'Your informations',
  'ACCOUNT_INFOS' => 'Account Informations',
  'GENERAL_INFOS' => 'General Informations',
  'LEAVE_EMPTY_NO_CHANGE_PASSWORD' => 'Leave this field empty if you do not wish to change your password.',
  'RANK' => 'Rank',
  'REGISTER_DATE' => 'Register Date',
  'GENRE' => 'Genre',
  'UNSPECIFIED' => 'Unspecified',
  'FEMALE' => 'Female',
  'MALE' => 'Male',
  'BIRTHDATE' => 'Birthdate',
  'COUNTRY' => 'Country',
  'CITY' => 'City',
  'VOTES_THIS_WEEK' => 'Votes this Week',
  'TOTAL_VOTES' => 'Total Number of Votes',
  'ARRIVED_HERE' => 'Arrived on this server',
  'RANK_VOTES' => 'Votes Rank',
  'COLON' => ':',
  'READ_MORE' => 'Read More',
  'NEW_PASSWORD' => 'New Password',
  'CONFIRM_PASSWORD' => 'Confirm Password'
));

// Buttons
$lang = array_merge($lang, array(
  'BTN_SEARCH' => 'Search',
  'BTN_CANCEL' => 'Cancel',
  'BTN_REGISTER' => 'Register',
  'BTN_LOGIN' => 'Sign in',
  'BTN_REMEMBER' => 'Stay signed in',
  'BTN_RESET' => 'Reset my Password',
  'BTN_EDIT' => 'Edit',
  'BTN_REMOVE' => 'Remove',
  'BTN_CLOSE' => 'Close',
  'BTN_SAVE' => 'Save',
  'BTN_NO' => 'No',
  'BTN_YES' => 'Yes',
  'BTN_I_REMEMBER' => 'Actually I remember!'
));

// URL
$lang = array_merge($lang, array(
  'URL_ADMIN' => 'admin',
  'URL_MANAGE' => 'manage',
  'URL_SIGN_IN' => 'sign-in',
  'URL_SIGN_OUT' => 'sign-out',
  'URL_REGISTER' => 'register',
  'URL_VERIFY' => 'verify',
  'URL_RESEND' => 'resend',
  'URL_RESET' => 'reset-password',
  'URL_PROFILE' => 'profile',
  'URL_PLAYER' => 'player',
  'URL_ARTICLE' => 'article'
));

//Account
$lang = array_merge($lang, array(
  'ACCOUNT_SPECIFY_USERNAME' => 'Please enter your username',
  'ACCOUNT_SPECIFY_PASSWORD' => 'Please enter your password',
  'ACCOUNT_SPECIFY_EMAIL' => 'Please enter your email address',
  'ACCOUNT_INVALID_EMAIL' => 'Invalid email address',
  'ACCOUNT_INVALID_USERNAME' => 'Invalid username',
  'ACCOUNT_USER_OR_EMAIL_INVALID' => 'username or email address is invalid',
  'ACCOUNT_USER_OR_PASS_INVALID' => 'username or password is invalid',
  'ACCOUNT_ALREADY_ACTIVE' => 'Your account is already activatived',
  'ACCOUNT_INACTIVE' => 'Your account is in-active. Check your emails / spam folder for account activation instructions',
  'ACCOUNT_USER_CHAR_LIMIT' => 'Your username must be no fewer than %m1% characters or greater than %m2%',
  'ACCOUNT_PASS_CHAR_LIMIT' => 'Your password must be no fewer than %m1% characters or greater than %m2%',
  'ACCOUNT_PASS_MISMATCH' => 'passwords must match',
  'ACCOUNT_USERNAME_IN_USE' => 'username %m1% is already in use',
  'ACCOUNT_EMAIL_IN_USE' => 'email %m1% is already in use',
  'ACCOUNT_LINK_ALREADY_SENT' => 'An activation email has already been sent to this email address in the last %m1% hour(s)',
  'ACCOUNT_NEW_ACTIVATION_SENT' => 'We have emailed you a new activation link, please check your email',
  'ACCOUNT_NOW_ACTIVE' => 'Your account is now active',
  'ACCOUNT_SPECIFY_NEW_PASSWORD' => 'Please enter your new password',
  'ACCOUNT_NEW_PASSWORD_LENGTH' => 'New password must be no fewer than %m1% characters or greater than %m2%',
  'ACCOUNT_PASSWORD_INVALID' => 'Current password doesn\'t match the one we have one record',
  'ACCOUNT_EMAIL_TAKEN' => 'This email address is already taken by another user',
  'ACCOUNT_DETAILS_UPDATED' => 'Account details updated',
  'ACTIVATION_MESSAGE' => 'You will need first activate your account before you can login, follow the below link to activate your account. \n\n
													%m1%activate-account.php?token=%m2%',
  'ACCOUNT_REGISTRATION_COMPLETE_TYPE1' => 'You have successfully registered. You can now login <a href=\'login.php\'>here</a>.',
  'ACCOUNT_REGISTRATION_COMPLETE_TYPE2' => 'You have successfully registered. You will soon receive an activation email. 
													You must activate your account before logging in.'
));

//Forgot password
$lang = array_merge($lang, array(
  'FORGOTPASS_INVALID_TOKEN' => 'Invalid token',
  'FORGOTPASS_NEW_PASS_EMAIL' => 'We have emailed you a new password',
  'FORGOTPASS_REQUEST_CANNED' => 'Lost password request cancelled',
  'FORGOTPASS_REQUEST_EXISTS' => 'There is already a outstanding lost password request on this account',
  'FORGOTPASS_REQUEST_SUCCESS' => 'We have emailed you instructions on how to regain access to your account'
));

//Miscellaneous
$lang = array_merge($lang, array(
  'CONFIRM' => 'Confirm',
  'DENY' => 'Deny',
  'SUCCESS' => 'Success',
  'ERROR' => 'Error',
  'NOTHING_TO_UPDATE' => 'Nothing to update',
  'SQL_ERROR' => 'Fatal SQL error',
  'MAIL_ERROR' => 'Fatal error attempting mail, contact your server administrator',
  'MAIL_TEMPLATE_BUILD_ERROR' => 'Error building email template',
  'MAIL_TEMPLATE_DIRECTORY_ERROR' => 'Unable to open mail-templates directory. Perhaps try setting the mail directory to %m1%',
  'MAIL_TEMPLATE_FILE_EMPTY' => 'Template file is empty... nothing to send',
  'FEATURE_DISABLED' => 'This feature is currently disabled'
));

$lang = array_merge($lang, array(
  'COUNTRIES' => array(
    'dz' => 'Algeria',
    'ad' => 'Andorra',
    'ag' => 'Antigua and Barbuda',
    'ar' => 'Argentina',
    'am' => 'Armenia',
    'au' => 'Australia',
    'at' => 'Austria',
    
    'be' => 'Belgium',
    'bo' => 'Bolivia',
    'br' => 'Brazil',
    'bg' => 'Bulgaria',
    'bf' => 'Burkina Faso',
    
    'cm' => 'Cameroon',
    'ca' => 'Canada',
    'td' => 'Chad',
    'cl' => 'Chile',
    'cn' => 'China',
    'co' => 'Colombia',
    'cg' => 'Congo',
    'cd' => 'Congo, Democratic Republic',
    'cz' => 'Czech Republic',
    
    'dk' => 'Denmark',
    'dj' => 'Djibouti',
    
    'eg' => 'Egypt',
    'sv' => 'El Salvador',
    'ee' => 'Estonia',
    
    'fi' => 'Finland',
    'fr' => 'France',
    
    'ga' => 'Gabon',
    'gm' => 'Gambia',
    'de' => 'Germany',
    'gt' => 'Guatemala',
    
    'ht' => 'Haiti',
    'hn' => 'Honduras',
    'hu' => 'Hungary',
    
    'in' => 'India',
    'id' => 'Indonesia',
    'ir' => 'Iran, Islamic Republic',
    'iq' => 'Iraq',
    'ie' => 'Ireland',
    'il' => 'Israel',
    'it' => 'Italy',
    
    'jm' => 'Jamaica',
    'jp' => 'Japan',
    'jo' => 'Jordan',
    
    'kz' => 'Kazakhstan',
    'kr' => 'Korea, Republic',
    'kp' => 'Korea, Dem. People\'s Republic',
    'kw' => 'Kuwait',
    'kg' => 'Kyrgyzstan',
    
    'la' => 'Lao People\'s Dem. Republic',
    'lv' => 'Latvia',
    'lb' => 'Lebanon',
    'ls' => 'Lesotho',
    'lu' => 'Luxembourg',
    
    'mk' => 'Macedonia',
    'mg' => 'Madagascar',
    'ml' => 'Mali',
    'mt' => 'Malta',
    'mx' => 'Mexico',
    'mm' => 'Myanmar',
    'na' => 'Namibia',
    
    'nl' => 'Netherlands',
    'ni' => 'Nicaragua',
    'ne' => 'Niger',
    'ng' => 'Nigeria',
    'no' => 'Norway',
    
    'om' => 'Oman',
    
    'pk' => 'Pakistan',
    'pa' => 'Panama',
    'pg' => 'Papua New Guinea',
    'py' => 'Paraguay',
    'pe' => 'Peru',
    'pl' => 'Poland',
    'pt' => 'Portugal',
    
    'qa' => 'Qatar',
    
    'ro' => 'Romania',
    'ru' => 'Russian Federation',
    'rw' => 'Rwanda',
    
    'kn' => 'Saint Kitts and Nevis',
    'lc' => 'Saint Lucia',
    'sa' => 'Saudi Arabia',
    'sn' => 'Senegal',
    'sl' => 'Sierra Leone',
    'sg' => 'Singapore',
    'so' => 'Somalia',
    'es' => 'Spain',
    'se' => 'Sweden',
    'ch' => 'Switzerland',
    
    'tj' => 'Tajikistan',
    'tz' => 'Tanzania',
    'tl' => 'Timor-Leste',
    'tr' => 'Turkey',
    
    'ua' => 'Ukraine',
    'ae' => 'United Arab Emirates',
    'gb' => 'United Kingdom',
    'us' => 'United States',
    
    've' => 'Venezuela',
    'vn' => 'Viet Nam',
    
    'ye' => 'Yemen'
  )
));