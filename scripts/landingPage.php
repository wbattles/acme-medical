<?php
require_once ('../app_config.php');
require_once (APP_ROOT . '/' . APP_FOLDER_NAME . '/scripts/echoHTML.php');

$jsFile = APP_FOLDER_NAME . '/clientScripts/customerRegistration.js';
$cssFile = APP_FOLDER_NAME . '/styles/customerRegistration.css';

echoHead($jsFile, $cssFile);
echoHeader("Customer Registration");

echo "
        <form action='customerRegistration.php' onsubmit='return checkPassword()' method='post'>
        <fieldset class='info-box'>
            <legend>Registration Information</legend>
            <div class='form-box'>
                <div class='form-entry'> 
                    <label>E-Mail:</label>
                    <input type='email' id='email' name='email' required>
                </div>
                
                <div class='form-entry'> 
                    <label>Password:</label>
                    <input type='password' id='password' pattern='[a-zA-Z0-9]{6,}'' name='password' placeholder='At least 6 letters or numbers' required><br>
                </div>

                <div class='form-entry'> 
                    <label>Verify Password:</label>
                    <input type='password' id='verify_password' pattern='[a-zA-Z0-9]{6,}' name='verify_password' required>
                </div>
            </div>
        </fieldset><br>

        <fieldset class='info-box'>
            <legend>Member Information</legend>
            <div class='form-box'>
                <div class='form-entry'> 
                    <label>First Name:</label>
                    <input type='text' id='fname' name='fname' required>
                </div>
                
                <div class='form-entry'> 
                    <label>State:</label>
                    <input type='text' minlength='2' maxlength='2' id='state' name='state' placeholder='2-character code' required><br>
                </div>

                <div class='form-entry'> 
                    <label>ZIP Code:</label>
                    <input type='number' id='zip' name='zip' pattern='[0-9]{5}' placeholder='5 of 9 digits' required>
                </div>

                <div class='form-entry'> 
                    <label>Phone Number:</label>
                    <input type='tel' id='phone' name='phone' pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}' placeholder='999-999-9999'>
                </div>
            </div>
        </fieldset><br>

        <fieldset class='info-box'>
            <legend>Member Information</legend>
            <div class='form-box'>
                <div class='form-entry'> 
                    <label>Membership Type:</label>
                    <select name='member_type' id='member_type'>
                        <option value='gold'>Gold</option>
                        <option value='silver'>Silver</option>
                        <option value='bronze'>Bronze</option>
                    </select>
                </div>
                
                <div class='form-entry'> 
                    <label for='start_date'>Starting Date:</label>
                    <input type='date' id='start_date' name='start_date' required>
                </div>
            </div>
        </fieldset><br>

        <fieldset class='submit-box'>
            <legend>Submit Your Membership</legend>
            <button type='submit'>Submit</button>
            <button type ='reset'>Reset Fields</button>
        </fieldset><br>
        </form>
";

echoFooter();