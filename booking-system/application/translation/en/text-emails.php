<?php

/*
 * Title                   : Pinpoint Booking System
 * File                    : application/translation/en/text-emails.php
 * Author                  : Dot on Paper
 * Copyright               : © 2017 Dot on Paper
 * Website                 : https://www.dotonpaper.net
 * Description             : Emails english text.
 */

    global $dot_text;

    $dot_text['EMAILS_PARENT'] = 'Email templates';
    
    $dot_text['EMAILS_TITLE'] = 'Email templates';
    $dot_text['EMAILS_CREATED_BY'] = 'Created by';
    $dot_text['EMAILS_LOAD_SUCCESS'] = 'Email templates list loaded.';
    $dot_text['EMAILS_NO_EMAILS'] = 'No email templates. Click the above "plus" icon to add new ones.';

    $dot_text['EMAILS_DEFAULT_NAME'] = 'Default email templates';

    /*
     * Default booking, with payment on arrival.
     */
    $dot_text['EMAILS_DEFAULT_BOOK_ADMIN_SUBJECT'] = 'You received a booking request.';
    $dot_text['EMAILS_DEFAULT_BOOK_ADMIN'] = 'Below are the details. Go to admin to approve or reject the request.';
    $dot_text['EMAILS_DEFAULT_BOOK_USER_SUBJECT'] = 'Your booking request has been sent.';
    $dot_text['EMAILS_DEFAULT_BOOK_USER'] = 'Please wait for approval. Below are the details.';
    
    /*
     * Booking with approval.
     */
    $dot_text['EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN_SUBJECT'] = 'You received a booking request.';
    $dot_text['EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN'] = 'Below are the details. Go to admin to cancel the request.';
    $dot_text['EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER_SUBJECT'] = 'Your booking request has been sent.';
    $dot_text['EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER'] = 'Below are the details.';
    
    /*
     * Approved reservation.
     */
    $dot_text['EMAILS_DEFAULT_APPROVED_SUBJECT'] = 'Your booking request has been approved.';
    $dot_text['EMAILS_DEFAULT_APPROVED'] = 'Congratulations! Your booking request has been approved. Details about your request are below.';
    
    /*
     * Canceled reservation.
     */
    $dot_text['EMAILS_DEFAULT_CANCELED_SUBJECT'] = 'Your booking request has been canceled.';
    $dot_text['EMAILS_DEFAULT_CANCELED'] = 'I<<single-quote>>m sorry but your booking request has been canceled. Details about your request are below.';
    
    /*
     * Rejected reservation.
     */
    $dot_text['EMAILS_DEFAULT_REJECTED_SUBJECT'] = 'Your booking request has been rejected.';
    $dot_text['EMAILS_DEFAULT_REJECTED'] = 'I<<single-quote>>m sorry but your booking request has been rejected. Details about your request are below.';

    $dot_text['EMAILS_EMAIL_NAME'] = 'Name';
    $dot_text['EMAILS_EMAIL_LANGUAGE'] = 'Language';

    $dot_text['EMAILS_EMAIL_TEMPLATE_SELECT'] = 'Select template';
    $dot_text['EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_ADMIN'] = 'Admin notification';
    $dot_text['EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_USER'] = 'User notification';
    $dot_text['EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_WITH_APPROVAL_ADMIN'] = 'Instant approval admin notification';
    $dot_text['EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_WITH_APPROVAL_USER'] = 'Instant approval user notification';
    $dot_text['EMAILS_EMAIL_TEMPLATE_SELECT_APPROVED'] = 'Approve resevation';
    $dot_text['EMAILS_EMAIL_TEMPLATE_SELECT_CANCELED'] = 'Cancel resevation';
    $dot_text['EMAILS_EMAIL_TEMPLATE_SELECT_REJECTED'] = 'Reject resevation';
    $dot_text['EMAILS_EMAIL_SUBJECT'] = 'Subject';
    $dot_text['EMAILS_EMAIL_MESSAGE'] = 'Message';

    $dot_text['EMAILS_EMAIL_LOADED'] = 'Email templates loaded.';

    $dot_text['EMAILS_ADD_EMAIL_NAME'] = 'New email templates';
    $dot_text['EMAILS_ADD_EMAIL_SUBMIT'] = 'Add email templates';
    $dot_text['EMAILS_ADD_EMAIL_ADDING'] = 'Adding new email templates ...';
    $dot_text['EMAILS_ADD_EMAIL_SUCCESS'] = 'You have succesfully added new email templates.';

    $dot_text['EMAILS_DELETE_EMAIL_CONFIRMATION'] = 'Are you sure you want to delete the email templates?';
    $dot_text['EMAILS_DELETE_EMAIL_SUBMIT'] = 'Delete email templates';
    $dot_text['EMAILS_DELETE_EMAIL_DELETING'] = 'Deleting email templates ...';
    $dot_text['EMAILS_DELETE_EMAIL_SUCCESS'] = 'You have succesfully deleted the email templates.';

    $dot_text['EMAILS_HELP'] = 'Click on a templates item to open the editing area.';
    $dot_text['EMAILS_ADD_EMAIL_HELP'] = 'Click on the "plus" icon to add email templates.';

    /*
     * Email help.
     */
    $dot_text['EMAILS_EMAIL_HELP'] = 'Click the "trash" icon to delete the email.';
    $dot_text['EMAILS_EMAIL_NAME_HELP'] = 'Change email templates name.';
    $dot_text['EMAILS_EMAIL_LANGUAGE_HELP'] = 'Change to the language you want to edit the email templates.';
    $dot_text['EMAILS_EMAIL_TEMPLATE_SELECT_HELP'] = 'Select the template you want to edit and modify the subject and message.';