<?php

/*
* Title                   : Pinpoint Booking System WordPress Plugin
* Version                 : 2.1.6
* File                    : views/emails/views-backend-email.php
* File Version            : 1.0.9
* Created / Last Modified : 16 February 2016
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Back end email views class.
*/

    if (!class_exists('DOPBSPViewsBackEndEmail')){
        class DOPBSPViewsBackEndEmail extends DOPBSPViewsBackEndEmails{
            /*
             * Constructor
             */
            function __construct(){
            }
            
            /*
             * Returns email template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): email ID
             *                      * language (string): email language
             *                      * template (string): email template
             * 
             * @return email HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->backend_language->get();
                $template = isset($args['template']) ? $args['template']:'book_admin';
                
                $email = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->emails.' WHERE id=%d',
                                                       $id));
                $template_data = $DOPBSP->classes->backend_email->get($id,
                                                                      $template);
?>
                <div class="dopbsp-inputs-wrapper dopbsp-last">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name',
                                              'label' => $DOPBSP->text('EMAILS_EMAIL_NAME'),
                                              'value' => $email->name,
                                              'email_id' => $email->id,
                                              'template' => '',
                                              'help' => $DOPBSP->text('EMAILS_EMAIL_NAME_HELP')));
?>
                
                    <!--
                        Language
                    -->
                    <div class="dopbsp-input-wrapper">
                        <label for="DOPBSP-email-language"><?php echo $DOPBSP->text('EMAILS_EMAIL_LANGUAGE'); ?></label>
<?php
                echo $this->getLanguages('DOPBSP-email-language',
                                         'DOPBSPBackEndEmail.display('.$email->id.', undefined, undefined, false)',
                                         $language,
                                         'dopbsp-left');
?>
                        <a href="javascript:void()" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('EMAILS_EMAIL_LANGUAGE_HELP'); ?></span></a>
                    </div>
                
                    <!--
                        Select template.
                    -->
                    <div class="dopbsp-input-wrapper">
                        <label for="DOPBSP-email-select-template"><?php echo $DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT'); ?></label>
                        <select name="DOPBSP-email-select-template" id="DOPBSP-email-select-template" class="dopbsp-left" onchange="DOPBSPBackEndEmail.display(<?php echo $email->id ?>, undefined, this.value, false)">
                            <option value="book_admin"<?php echo $template == 'book_admin' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_ADMIN'); ?></option>
                            <option value="book_user"<?php echo $template == 'book_user' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_USER'); ?></option>
                            <option value="book_with_approval_admin"<?php echo $template == 'book_with_approval_admin' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_WITH_APPROVAL_ADMIN'); ?></option>
                            <option value="book_with_approval_user"<?php echo $template == 'book_with_approval_user' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_BOOK_WITH_APPROVAL_USER'); ?></option>
                            <option value="approved"<?php echo $template == 'approved' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_APPROVED'); ?></option>
                            <option value="canceled"<?php echo $template == 'canceled' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_CANCELED'); ?></option>
                            <option value="rejected"<?php echo $template == 'rejected' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_REJECTED'); ?></option>
<?php
                $pg_list = $DOPBSP->classes->payment_gateways->get();

                for ($i=0; $i<count($pg_list); $i++){
                    $pg_id = $pg_list[$i];
                    
                    echo '<option value="'.$pg_id.'_admin"'.($template == $pg_id.'_admin' ? ' selected="selected"':'').'>'.$DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_'.strtoupper($pg_id).'_ADMIN').'</option>';
                    echo '<option value="'.$pg_id.'_user"'.($template == $pg_id.'_user' ? ' selected="selected"':'').'>'.$DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_'.strtoupper($pg_id).'_USER').'</option>';
                }
?>
                        </select>
                        <script type="text/JavaScript">jQuery('#DOPBSP-email-select-template').DOPSelect();</script>
                        <a href="javascript:void()" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help"><?php echo $DOPBSP->text('EMAILS_EMAIL_TEMPLATE_SELECT_HELP'); ?></span></a>
                    </div>
<?php           
                $this->displayTextInput(array('id' => 'subject',
                                              'label' => $DOPBSP->text('EMAILS_EMAIL_SUBJECT'),
                                              'value' => $DOPBSP->classes->translation->decodeJSON($template_data->subject, $language),
                                              'email_id' => $email->id,
                                              'template' => $template,
                                              'help' => '',
                                              'container_class' => '',
                                              'input_class' => 'dopbsp-subject'));
                $this->displayTextarea(array('id' => 'message',
                                             'label' => $DOPBSP->text('EMAILS_EMAIL_MESSAGE'),
                                             'value' => $DOPBSP->classes->translation->decodeJSON($template_data->message, $language),
                                             'email_id' => $email->id,
                                             'template' => $template,
                                             'container_class' => 'dopbsp-last',
                                             'input_class' => 'dopbsp-message'));
?>
                </div>
<?php 
            }

/*
 * Inputs.
 */         
            /*
             * Create a text input for email.
             * 
             * @param args (array): function arguments
             *                      * id (integer): email field ID
             *                      * label (string): email label
             *                      * value (string): email current value
             *                      * email_id (integer): email ID
             *                      * template (integer): email template
             *                      * help (string): email help
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $email_id = $args['email_id'];
                $template = $args['template'];
                $help = isset($args['help']) ? $args['help']:'';
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-email-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-email-'.$id.'" id="DOPBSP-email-'.$id.'" class="'.$input_class.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndEmail.edit('.$email_id.', \''.$template.'\', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPBackEndEmail.edit('.$email_id.', \''.$template.'\', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPBackEndEmail.edit('.$email_id.', \''.$template.'\', \'text\', \''.$id.'\', this.value, true)" />');
                
                if ($help != ''){
                    array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="dopbsp-button dopbsp-help"><span class="dopbsp-info dopbsp-help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                }
                array_push($html, ' </div>');

                echo implode('', $html);
            }
                
            /*
             * Create a textarea input for email.
             * 
             * @param args (array): function arguments
             *                      * id (integer): email field ID
             *                      * label (string): email label
             *                      * value (string): email current value
             *                      * email_id (integer): email ID
             *                      * template (integer): email template
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return text input HTML
             */
            function displayTextarea($args = array()){
                $html = array();
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $email_id = $args['email_id'];
                $template = $args['template'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';

                array_push($html, ' <div class="dopbsp-input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-email-'.$id.'">'.$label.'</label>');
                array_push($html, '     <textarea name="DOPBSP-email-'.$id.'" id="DOPBSP-email-'.$id.'" cols="" rows="12" class="'.$input_class.'" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPBackEndEmail.edit('.$email_id.', \''.$template.'\', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPBackEndEmail.edit('.$email_id.', \''.$template.'\', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPBackEndEmail.edit('.$email_id.', \''.$template.'\', \'text\', \''.$id.'\', this.value, true)">'.$value.'</textarea>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
        }
    }