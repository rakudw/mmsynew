<div class="col-12">
    <div class="table-responsive">
        <table class="table" id="partnersTable">
            <caption class="alert alert-warning text-white">
                <strong>Note:</strong>
                All the Partners/Shareholders should be
                <abbr
                    title="Bonafide certificate is certification provided to the citizen by the government confirming and testifying their place of residence in the district of Himachal Pradesh.">Himachali
                    Bonafied</abbr>.
            </caption>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Social Category</th>
                    <th>Specially Abled</th>
                    <th>Aadhaar Number</th>
                    <th>Mobile<br /><small>(Linked to the Aadhaar)</small></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input name="partner_name[]" required="required" type="text" placeholder="Name"
                            class="form-control" /></td>
                    <td><select name="partner_gender[]" data-simple="true" class="form-control" data-partner-gender="true">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select></td>
                    <td><input name="partner_birth_date[]" type="date" required="required"
                            data-datepicker-xformat="yyyy-mm-dd" data-datepicker-xmax-date="-18" placeholder="Date of Birth" pattern="\d\d\d\d-(\d)?\d-(\d)?\d"
                            data-age-next="true" data-age="true" class="form-control" data-partner-dob="true" />
                        <span class="badge badge-info bg-dark"></span>
                    </td>
                    <td><select name="partner_social_category_id[]" data-simple="true" class="form-control">
                            @foreach (\App\Enums\SocialCategoryEnum::cases() as $case)
                                <option value="{{ $case->id() }}">{{ $case->name }}</option>
                            @endforeach
                        </select></td>
                    <td><select name="partner_is_specially_abled[]" data-simple="true" class="form-control">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select></td>
                    <td><input name="partner_aadhaar[]" required="required" type="tel" placeholder="Aadhaar number"
                            class="form-control" pattern="^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$" /></td>
                    <td><input name="partner_mobile[]" required="required" type="tel" placeholder="Mobile"
                            class="form-control" pattern="[1-9]{1}[0-9]{9}" /></td>
                    <td></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center" colspan="5"><button type="button"
                            class="btn btn-sm btn-success duplicatePreviousRowButton"><i class="fa fa-plus"></i> Add
                            more</button></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
