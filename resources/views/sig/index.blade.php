@extends('layouts.master')
@section('content')
@include('flash.success')
<h2 class='line-break'>Special Interest Groups</h2>
<div class="well">
    <p>
        <span class="larger bold">Second call</span>
    </p>
    <p>
        UKFN is pleased to invite proposals for a second round of Special Interest Groups. 
        This call is open to anyone working in fluid mechanics in the UK. 
        The following pdf gives the context of the call and sets out the information you need to provide in your proposal:
    </p>
    <p>
        <a href="{{ asset('files/UKFN_SIGs_2nd_call_for_proposals.pdf') }}">[UKFN_SIGs_2nd_call_for_proposals.pdf]</a>
    </p>
    <p>
        The closing date is 31 January 2017.
    </p>
    <p>
        Information about the results of the first call, which you may find helpful, is given below.
    </p>
</div>

<div>
    <h3>Results of the first call</h3>
    <p>
        A total of 46 proposals were received in response to the first call for SIG proposals, of which 26 were approved for funding. 
        These are listed in alphabetical order below.
    </p>
    <div class="table-responsive pull-left">
        <table class='table'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Lead</th>
                    <th>Co-lead(s)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sigs as $sig)
                <tr>
                    <td>{{ $sig->id }}</td>
                    <td>{{ $sig->name }}</td>
                    <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                    <td>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p>
        Further statistics on proposals received for the first call may be found here:
    </p>
    <p>
        <a href="{{ asset('files/UKFN_SIGs_Call1_summary.xlsx') }}">[UKFN_SIGs_Call1_summary.xlsx]</a>
    </p>
    <p>
        This workbook contains the following additional information:<br>
        <span class='margin-left'>(a) List of all proposals submitted</span><br>
        <span class='margin-left'>(b) Charts showing distribution of proposals across institutions and subject areas</span><br>
        <span class='margin-left'>(c) List of activities and outputs proposed</span><br>
        <span class='margin-left'>(d) List of suggestions compiled on SIG web page during first call</span>
    </p>
</div>

@include('sig.suggestions')
@endsection