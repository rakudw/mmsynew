<div class="mmsy_tips_sections">
        <div class="imaportant_tips">
            <img src="images/imswa1.png" />
        </div>
        <div class="important_tips">
            <h3>Useful Tips For Applicant</h3>
            <ul class="list_signup">
                @foreach($usefultips as $key => $tip)
                    <li ><i class="fa fa-check" aria-hidden="true"></i> {{ $tip->description }}</li>
                @endforeach
                <!-- <li><i class="fa fa-check" aria-hidden="true"></i> You can use either email or phone number while login
                </li>
                <li><i class="fa fa-check" aria-hidden="true"></i> Forgot password will send new password into your
                    mobile number</li>
                <li><i class="fa fa-check" aria-hidden="true"></i> Fill application with detail which is asked in form
                </li>
                <li><i class="fa fa-check" aria-hidden="true"></i> Aadhaar and Name will match to the original aadhar
                    no.</li>
                <li><i class="fa fa-check" aria-hidden="true"></i> Be careful while selecting district applying for</li>
                <li><i class="fa fa-check" aria-hidden="true"></i> Age must be between 18 to 45 year old</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>Type of activity is depen on your nature of your</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>Qualification is beneficial for choosing industry</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>Land cost estimate will be mandatory</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>You must not be a defaulter in any bank</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>Land Record and PPR is in PDF format and allowed size
                    is 600 Kb</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>From security option you can update your password</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>With the help of bell icon you will know about the
                    status of application</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>You can choose any bank in bank info</li> -->
            </ul>
        </div>

    </div>
