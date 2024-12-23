@extends('layouts.applicant')

@section('title', $title ?? 'Application for Approval')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark text-decoration-none"
                    href="{{ route('applications.list') }}">{{ __('Applications') }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                {{ $title ?? __('Application for Approval') }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $title ?? __('Application for Approval') }}</h6>
    </nav>
@endsection

@section('content')
@include('shared.front-end.applicant_header')

    <div class="row " id="formHolder">
        <div class="col-12">
            <x-forms.form :activities="$activity" :cons="$con" :diss="$Diss" :cats="$CAT" :banks="$bank" :application="$application" :bankid="$bankid" :ispreview="$ispreview"/>
        </div>
    </div>
@endsection
<style>
    tr.sub_row th {
        background: white !important;
        border-right: 1px solid black !important;
    }
    .backk, .style1{
        height: 30px;
        background-color: #E36E2C !important;
        border-radius: 5px;
    }
</style>
@section('scripts')
<script src="https://sso.hp.gov.in/nodeapi/iframe/iframe.js" defer=""></script>
<script>
    $(document).ready(function() {
        @if (!Auth::check())
            // getIframeSSO("10000074")
        @endif
        @if($errors->any())
            $('#myModalError').show();
            @endif
            $('.closeMe').click(function(){
                $('#myModalError').hide();
            })
        // When the page is loaded, check the initial value of marital status
        checkMaritalStatus();
    
        // Attach an event handler to the marital status dropdown
        $("#marital_status").change(function() {
            checkMaritalStatus();
        });
    
        function checkMaritalStatus() {
            // Get the selected value of the marital status dropdown
            var maritalStatus = $("#marital_status").val();
    
            // Check if the selected value is "Married"
            if (maritalStatus === "Married") {
                // If "Married" is selected, enable the spouse's Aadhaar number input field
                $("#spouse_aadhaar").prop("disabled", false);
                $("#spouse_aadhaar").prop("required", true);
            } else {
                // If any other value is selected, disable the spouse's Aadhaar number input field
                $("#spouse_aadhaar").prop("disabled", true);
            }
        }

       
        $("#constitution_type_id").change(function() {
            // Check if the selected value is "101" (Proprietorship)
            if ($(this).val() === "101" || $(this).val() === "") {
                // Remove the "required" attribute from all input fields and selects in the modal
                $('#ConstitutionModal input, #ConstitutionModal select').prop('required', false);
                
                // Clear all input fields in the modal
                $('#ConstitutionModal input').val('');
                $('#ConstitutionModal select').val('');
                
                // Close the modal
                $('#ConstitutionModal').modal('hide');
            } else {
                // Show the modal
                $('#ConstitutionModal').modal('show');
                
                // Add the "required" attribute back to input fields and selects
                $('#ConstitutionModal input, #ConstitutionModal select').prop('required', true);
            }
        });
        $("#constitution_type_id").trigger('change');
        document.getElementById('addPartnerButton').addEventListener('click', function() {
            const partnerRowTemplate = document.querySelector('.partner-row');
            const newPartnerRow = partnerRowTemplate.cloneNode(true);
            newPartnerRow.style.display = 'flex';
            // $('.partner-row:first .remove-partner-button').hide();
            document.getElementById('partnerShareholderContainer').appendChild(newPartnerRow);
            attachRemoveButtonHandler(newPartnerRow);
        });

        // Remove Button Functionality
        function attachRemoveButtonHandler(row) {
            const removeButton = row.querySelector('.remove-partner-button');
            removeButton.addEventListener('click', function() {
                row.remove();
            });
            
        }
        let isRemovingPartner = false;

        $('.remove-partner-button').click(function () {
            var partnerRows = $('.partner-row');
            // Check if this is the last partner row
            if (partnerRows.length === 1) {
                // Display a confirmation popup before removing
                if (confirm('Are you sure you want to delete the last partner? This will change the Constitution type to proprietorship and remove partner details.')) {
                    isRemovingPartner = true; // Set the flag to indicate partner removal

                    // Change the Constitution type to proprietorship
                    $('#constitution_type_id').val('101'); // Assuming the field ID is "constitution_type"

                    // Remove the partner details
                    const partnerInputs = partnerRows.find('input, select');
                    partnerInputs.val('');
                    partnerInputs.removeAttr('required');

                    partnerRows.find('.partner-row:not(:first) .remove-partner-button').prop('disabled', true);
                    $('#viewButton').hide();
                    
                    // Close the popup
                    $('#ConstitutionModal').modal('hide');
                }
            } else {
                $(this).closest('.partner-row').remove();
            }
        });

        $('#ConstitutionModal').on('hide.bs.modal', function (e) {
            if (!isRemovingPartner) {
                const requiredFields = $('.partner-row [required]');
                let isValid = true;
                requiredFields.each(function () {
                    if (!$(this).val()) {
                        isValid = false;
                        return false; // Exit the loop on the first empty field
                    }
                });
                var aadhaarPattern = /^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/;
                var mobilePattern = /^[6-9]{1}[0-9]{9}$/;

                // Validate Aadhaar and mobile numbers
                var $aadhaarInputs = $('input[name^="partner_aadhaar"]');
                var $mobileInputs = $('input[name^="partner_mobile"]');
                
                $aadhaarInputs.each(function () {
                    if (!aadhaarPattern.test($(this).val())) {
                        console.log('Invalid Aadhaar Input');
                        isValid = false;
                        // Optionally, you can display an error message or style the input fields here.
                    }
                });

                $mobileInputs.each(function () {
                    if (!mobilePattern.test($(this).val())) {
                        console.log('Invalid Mobile Input');
                        isValid = false;
                        // Optionally, you can display an error message or style the input fields here.
                    }
                });
                
                if (!isValid) {
                    e.preventDefault(); // Prevent modal from closing
                    alert('Please fill in all required fields correctly.');
                }
            }

            // Reset the flag
            isRemovingPartner = false;
        });


        const activityTypeDropdown = $('#activity_type_id');
        const activityDropdown = $('#activity_id');
        const activityDescription = $('#activity_details');
        const productsField = $('#products');

        // Function to toggle field disabled state and required attribute
        function toggleFieldStatus(field, isDisabled, isRequired) {
            field.prop('disabled', isDisabled);
            field.prop('required', isRequired);
        }

        // Initial setup based on the selected value
        activityTypeDropdown.on('change', function() {
            const selectedValue = $(this).val();
            console.log('selectedValue', selectedValue)

            if (selectedValue == 201) { // If "Manufactured" is selected
                toggleFieldStatus(activityDescription, true, false);
                toggleFieldStatus(productsField, false, true);

                // Clear the value of the productsField
                activityDescription.val('');
            } else {
                toggleFieldStatus(activityDescription, false, true);
                toggleFieldStatus(productsField, true, false);

                // Clear the value of the activityDescription field
                productsField.val('');
            }
        });

        // Trigger change event on page load
        activityTypeDropdown.trigger('change');

        const landStatusDropdown = $('#land_status');
        const landCostInput = $('#land_cost');

        // Function to toggle field disabled state and required attribute
        function toggleFieldStatus(field, isDisabled, isRequired) {
            field.prop('disabled', isDisabled);
            field.prop('required', isRequired);
        }

        // Initial setup based on the selected value
        landStatusDropdown.on('change', function() {
            const selectedValue = $(this).val();
            
            if (selectedValue === 'To be Purchased' || selectedValue === 'To be Taken on Lease') {
                toggleFieldStatus(landCostInput, false, true);
            } else {
                toggleFieldStatus(landCostInput, true, false);
                landCostInput.val('');
            }
        });

        
        // Trigger change event on page load
        landStatusDropdown.trigger('change');

        // Get references to the elements
    const buildingStatusDropdown = $('#building_status');
    const buildingCostInput = $('#building_cost');

    // Function to toggle field disabled state and required attribute
    function toggleFieldStatus(field, isDisabled, isRequired) {
        field.prop('disabled', isDisabled);
        field.prop('required', isRequired);
    }

    // Initial setup based on the selected value
    buildingStatusDropdown.on('change', function() {
        const selectedValue = $(this).val();
        
        if (selectedValue === 'To be Constructed' || selectedValue === 'To be Taken on Rent') {
            toggleFieldStatus(buildingCostInput, false, true);
        } else {
            toggleFieldStatus(buildingCostInput, true, false);
            buildingCostInput.val('');
        }
    });

    // Trigger change event on page load
    buildingStatusDropdown.trigger('change');

    function calculateTotal() {
        // Initialize total amount to 0
        let totalAmount = 0
        // Get the values of subsidized components
        const buildingCost = parseFloat($('#building_cost').val()) || 0;
        const landCost = parseFloat($('#land_cost').val()) || 0;
        const assetsCost = parseFloat($('#assets_cost').val()) || 0;
        const machineryCost = parseFloat($('#machinery_cost').val()) || 0;
        const working_capital = parseFloat($('#working_capital_cc').val()) || 0;

        // Sum the values of subsidized components
        totalAmount = buildingCost + assetsCost + machineryCost + working_capital + landCost;
        // Update the total amount field
        // const activityTypeSelect = document.getElementById('activity_type_id');

        // activityTypeSelect.addEventListener('change', () => {
        //     const selectedActivityType = activityTypeSelect.value;
        //     if (selectedActivityType === '84') {
        //         projectCostInput.setAttribute('max', '100000'); // 10 lakhs
        //         projectCostInput.setCustomValidity('Admissible Project cost under this scheme is up to 10 lakhs.');
        //     } else {
        //         projectCostInput.setAttribute('max', '1000000'); // 1 crore
        //         projectCostInput.setCustomValidity('Admissible Project cost under this scheme is up to 1 crore.');
        //     }
        // });
        $('#project_cost').val(totalAmount.toFixed(2));
        return totalAmount.toFixed(2)
    }

    // Attach input event handlers to the subsidized fields
    $('#building_cost,#land_cost, #assets_cost, #machinery_cost, #working_capital_cc').on('input', function() {
        console.log("Input field value changed.");
        calculateTotal();
        var total = calculateTotal();
        // console.log(total);
        if (total > 10000000) {
            // Show popup
            alert("Admissible Project cost under this scheme is up to 1cr!");
        }
    });

    // Calculate the initial total amount
    calculateTotal();
    function onClickFunction() {
            // Your onclick logic here
            // calculateTotal();
        var total = calculateTotal();
        console.log("total",total);
        if (total > 10000000) {
            // Show popup
            alert("Admissible Project cost under this scheme is up to 1cr!");
        }
        }
        $('#submit-button').on('click', onClickFunction);
    // Function to calculate Own Contribution Amount
    function calculateOwnContributionAmount() {
        const projectCost = parseFloat($('#project_cost').val()) || 0;
        const ownContributionPercentage = parseFloat($('#own_contribution').val()) || 0;
        const ownContributionAmount = (projectCost * (ownContributionPercentage / 100)).toFixed(2);

        $('#own_contribution_amount').val(ownContributionAmount);
    }

    // Attach input event handlers to trigger calculation
    $('#own_contribution').on('input', function () {
        calculateOwnContributionAmount();
    });

    // Initial calculation
    calculateOwnContributionAmount();
    });

    function calculateCapitalExpenditure() {
        const landCost = parseFloat($('#land_cost').val()) || 0;
        const buildingCost = parseFloat($('#building_cost').val()) || 0;
        const assetsCost = parseFloat($('#assets_cost').val()) || 0;
        const machineryCost = parseFloat($('#machinery_cost').val()) || 0;

        const capitalExpenditure = (landCost + buildingCost + assetsCost + machineryCost).toFixed(2);

        $('#capital_expenditure').val(capitalExpenditure);
    }

    // Attach input event handlers to trigger calculation
    $('#land_cost, #building_cost, #assets_cost, #machinery_cost').on('input', function () {
        calculateCapitalExpenditure();
    });

    // Initial calculation
    calculateCapitalExpenditure();

    function calculateTermLoan() {
        const projectCost = parseFloat($('#project_cost').val()) || 0;
        const ownContributionAmount = parseFloat($('#own_contribution_amount').val()) || 0;
        const workingCapital = parseFloat($('#working_capital_cc').val()) || 0;

        const termLoan = (projectCost - ownContributionAmount - workingCapital);
        $('#term_loan').val(termLoan.toFixed(2));
        return termLoan.toFixed(2)
    }

    // Attach input event handlers to trigger calculation
    $('#project_cost, #working_capital_cc, #own_contribution').on('focusout', function () {
        calculateTermLoan();
    });

    // Initial calculation
    calculateTermLoan();

     // Function to calculate Working Capital
     function calculateWorkingCapital() {
        const workingCapital = parseFloat($('#working_capital_cc').val()) || 0;
        const ownContribution = parseFloat($('#own_contribution').val()) || 0;
        const calculatedWorkingCapital = workingCapital - (workingCapital * (ownContribution) / 100)

        $('#working_capital').val(calculatedWorkingCapital.toFixed(2));
    }

    // Attach input event handlers to trigger calculation
    $(' #own_contribution').on('input', function () {
        calculateWorkingCapital();
    });

    // Initial calculation
    calculateWorkingCapital();


    function toggleAadharFieldBasedOnMaritalStatus() {
    var maritalStatus = document.getElementById('marital_status');
    var aadharField = document.getElementById('aadhar_number_field');
    var aadharInput = document.getElementById('s_aadhar_number');

    function toggleAadharField() {
        if (maritalStatus.value === 'Married') {
            aadharField.style.display = 'block';
            aadharInput.required = true;
        } else {
            aadharField.style.display = 'none';
            aadharInput.required = false;
        }
    }

    document.addEventListener('DOMContentLoaded', toggleAadharField);

    maritalStatus.addEventListener('change', toggleAadharField);
}

toggleAadharFieldBasedOnMaritalStatus();
</script>
@endsection
