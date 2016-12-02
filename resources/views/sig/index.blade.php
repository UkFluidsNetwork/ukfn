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
    <div class="table-responsive clear-both">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Lead</th>
                    <th>Co-lead(s)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Aeroacoustics</td>
                    <td>Cambridge</td>
                    <td>Bristol</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Biologically active fluids</td>
                    <td>Cambridge</td>
                    <td>Birmingham</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Boundary layers in complex rotating systems</td>
                    <td>Leicester</td>
                    <td>Cardiff</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Challenges in cardiovascular flow modelling</td>
                    <td>Swansea</td>
                    <td>Bristol</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Drop dynamics</td>
                    <td>Oxford</td>
                    <td>QMUL</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Droplet and flow interactions with bio-inspired and smart surfaces</td>
                    <td>Northumbria</td>
                    <td>Durham</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Experimental flow diagnostics (xFD)</td>
                    <td>ICL</td>
                    <td>Cambridge</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Flow instability, modelling and control</td>
                    <td>ICL</td>
                    <td>Southampton</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Fluid dynamics of liquid crystalline materials</td>
                    <td>Strathclyde</td>
                    <td>Nottinham Trent</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Fluid mechanics of cleaning and decontamination</td>
                    <td>Manchester</td>
                    <td>Cambridge</td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>Fluid mechanics of the eye</td>
                    <td>ICL</td>
                    <td>Oxford</td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>Granular flows in the environment and industry</td>
                    <td>Cambridge</td>
                    <td>Edinburgh/Sheffield</td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>Low-energy ventilation</td>
                    <td>Leeds</td>
                    <td>ICL</td>
                </tr>
                <tr>
                    <td>14</td>
                    <td>Marine hydrodynamics</td>
                    <td>Southampton</td>
                    <td>Newcastle</td>
                </tr>
                <tr>
                    <td>15</td>
                    <td>Multicore and Manycore Algorithms to Tackle Turbulent flows (MUMATUR)</td>
                    <td>ICL</td>
                    <td>STFC</td>
                </tr>
                <tr>
                    <td>16</td>
                    <td>Multiphase flows and transport phenomena</td>
                    <td>Edinburgh</td>
                    <td>UCL</td>
                </tr>
                <tr>
                    <td>17</td>
                    <td>Multi-scale and non-continuum flows</td>
                    <td>Edinburgh</td>
                    <td>Warwick</td>
                </tr>
                <tr>
                    <td>18</td>
                    <td>Multi-scale processes in geophysical fluid dynamics</td>
                    <td>UCL</td>
                    <td>Oxford/St. Andrews</td>
                </tr>
                <tr>
                    <td>19</td>
                    <td>Next generation time-stepping strategies for computer simulations of multi-scale fluid flows </td>
                    <td>Leeds</td>
                    <td>Exeter/ICL</td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>Non-Newtonian fluid mechanics</td>
                    <td>Liverpool</td>
                    <td>Edinburgh</td>
                </tr>
                <tr>
                    <td>21</td>
                    <td>Particulate matter filtration flows in automotive and marine applications</td>
                    <td>Coventry</td>
                    <td>Loughborough</td>
                </tr>
                <tr>
                    <td>22</td>
                    <td>Turbulent free shear flows</td>
                    <td>Edinburgh</td>
                    <td>Leicester</td>
                </tr>
                <tr>
                    <td>23</td>
                    <td>Turbulent skin-friction drag reduction</td>
                    <td>ICL</td>
                    <td>Nottingham</td>
                </tr>
                <tr>
                    <td>24</td>
                    <td>Urban fluid mechanics</td>
                    <td>Southampton</td>
                    <td>ICL</td>
                </tr>
                <tr>
                    <td>25</td>
                    <td>User's forum for National Wind Tunnel Facility</td>
                    <td>Nottingham</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>26</td>
                    <td>Wave-structure interaction</td>
                    <td>Plymouth</td>
                    <td>MMU</td>
                </tr>
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
