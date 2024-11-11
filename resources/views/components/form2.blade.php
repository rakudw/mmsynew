<form method="post" action="{{ route('application.store', ['form' => $form->id,'formDesign' => $design->id,'application' => $application->id]) }}">
    @csrf
        <table class="table">
            <tbody>
                <tr>
                    <td class="td-1">
                        <table class="table">
                            <tbody>
                                <tr bgcolor="#E36E2C">
                                    <td colspan="6">
                                        <div align="center" class="style1">
                                            <h6>Application For The Approval Under Mukhya Mantri Swavlamban Yojana/मुख्यमंत्री स्वावलंबन योजना के अंतर्गत मंजूरी के लिए आवेदन</h6>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($formDesigns as $formDesign)
                                    @if($formDesign->id == 1) 
                                        <tr>
                                                <th class="section-heading">@if($formDesign->id == 1) (A) @endif</th>
                                                <th class="section-heading" ><strong>@if($formDesign->id == 1) Enterprise / उद्यम*  @endif
                                                        <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                                        <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                                </strong></th>
                                                <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                                Fill Enterprise Information / उद्यम जानकारी भरें</th>
                                            
                                            
                                        </tr>
                                        @foreach ($design->design as $element)
                                            
                                                <x-element2 :application="$application" :design="$design" :form="$form" :element="$element" />
                                            
                                        @endforeach
                                    @elseif($formDesign->id == 2)  
                                        <tr>
                                                <th class="section-heading">(B)</th>
                                                <th class="section-heading" ><strong>Legal Type/कानूनी  प्रकार
                                                        <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                                        <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                                </strong></th>
                                                <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                                Enter the details of major partner below / मुख्य साथी की विवरण नीचे दर्ज करें।</th>
                                            
                                            
                                        </tr>
                                        @foreach ($design2->design as $element)
                                            
                                                <x-element2 :application="$application" :design="$design" :form="$form" :element="$element" />
                                            
                                        @endforeach
                                    @elseif($formDesign->id == 3)  
                                        <tr>
                                                <th class="section-heading">(C)</th>
                                                <th class="section-heading" ><strong>Project Cost / परियोजना की लागतण
                                                        <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                                        <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                                </strong></th>
                                                <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                                Project Cost / परियोजना की लागतण</th>
                                            
                                            
                                        </tr>
                                    @elseif($formDesign->id == 4)  
                                        <tr>
                                                <th class="section-heading">(D)</th>
                                                <th class="section-heading" ><strong>Means of Finance / वित्त प्राधिकृति
                                                        <input name="FH_NAME" id="FH_NAME" type="hidden" value="-">
                                                        <input name="FH_NM_DESC" id="FH_NM_DESC" type="hidden" value="-">
                                                </strong></th>
                                                <th colspan="4"> <input name="BENF_TYPE_CD" id="BENF_TYPE_CD" type="hidden" value="1">
                                                Means of Finance / वित्त प्राधिकृति</th>
                                            
                                            
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table class="CSSTableGenerator">
                            <tbody>
                                <tr bgcolor="#E36E2C">
                                    <td colspan="2"><h6 align="center" class="style1"> Guidelines for Filling the Online MMSY Application /
                                        ऑनलाइन एमएमएसवाई  आवेदन भरने हेतु दिशानिर्देश</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>(1)</td>
                                    <td><strong>Aadhaar Number/आधार  नंबर</strong> : 12 digit Aadhar number of the applicant should be filled in./आधार  नंबर: आवेदन को 12 अंकों का आधार नंबर भरना चाहिए </td>
                                </tr>
                                <tr>
                                    <td >(A)</td>
                                        <td>The EID is displayed on the top of your enrolment/update acknowledgement slip and contains 14 digit enrolment number (1234/12345/12345) and the 14 digit date and time (yyyy/mm/dd hh:mm:ss) of enrolment. These 28 digits together form your Enrolment ID (EID)./
                                        <strong>    ईआईडी आपके नामांकन/अपडेट पावती पर्ची के शीर्ष पर प्रदर्शित होता है और इसमें 14 अंकों की नामांकन संख्या (1234/12345/12345) और नामांकन की 14 अंकों की तारीख और समय (yyyy/mm/dd hh:mm:ss) होता है। ये 28 अंक मिलकर आपकी नामांकन आईडी (ईआईडी) बनाते हैं।	 </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>(2)</td>
                                    <td><strong>Name of Applicant/आवेदक  का नाम : (i) </strong>Select prefix of name from the list/सूची  से नाम का सम्बोधन चुने, (ii) The applicant should fill his/her name exactly as it appears in the Aadhaar Card. In case of any mismatch in the name entered, the applicant will not be able to fill the form further/आवेदक  को अपना नाम ठीक उसी तरह भरना चाहिए जैसे आधार कार्ड मे दर्ज किया गया है | दर्ज किए गए नाम मेँ किसी भी प्रकार  से बेमेल होने के मामले में,आवेदक आगे फॉर्म नहीं भर पाएगा |. </td>
                                </tr>
                                <tr>
                                    <td>(3) </td>
                                    <td><p><strong>Sponsoring Agency</strong>/प्रायोजक  एजेंसी :  Select Agency  (KVIC, KVIB, DIC) in which you want to submit the application form/उस एजेंसी (KVIC, KVIB, DIC) का चयन करें, जिसमें आप आवेदन पत्र जमा करना चाहते हैं |. </p></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

</form>
