<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

<form class="form application-form" action="/application/save-data/" method="POST" id="applicant-form">
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
                                            <h6>Upload Document</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="dochead">{{$application->id}}</th>
                                    <th class="section-heading" ><strong>{{$application->name}}
                                </tr>
                                @foreach($doctype as $doc)
                                    <tr>
                                        <th>{{doc->id}}</th>
                                        <th ><strong>{{doc->name}}</strong></th>
                                        <td colspan="4">
                                            <input type="file" id="name" name="name" required autofocus>
                                            <small>{{doc->name}}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
    </table>
    </form>


