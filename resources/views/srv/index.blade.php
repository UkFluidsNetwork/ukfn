@extends('layouts.master')
@section('content')

  <h2 class='line-break'>Short Research Visits</h2>
  <div class="well">
    <p>
      UKFN is pleased to invite proposals for SRVs.
      The call is open to anyone working in fluid mechanics in the UK.
      The following pdf gives the context of the call and sets out the information you need to provide in your proposal:
    <p>
    <p>
      [<a href="{{ asset('files/UKFN_SRVs_call_170216.pdf') }}">UKFN_SRVs_call_170216.pdf</a>]
    </p>
    <p>
      Proposals will be assessed in batches every 4 months. The next deadline is 30 September 2017.
    </p>
  </div>
  
    <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv1" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
            <i ng-class="{'glyphicon-chevron-up': isCollapsed, 'glyphicon-chevron-down': !isCollapsed}" class='glyphicon pull-right'></i>

        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                Advancing Atmospheric Models: Aspects of Spatial Discretisation
            </div>
        </span>
        
        <span class="talks-speaker display-block">Dr Joanna Szmelter</span>
        <span class="display-block">Wolfson School of Mechanical, Electrical and Manufacturing Engineering</span>
        <span class="display-block line-break">Loughborough University</span>
        <span class="display-block line-break">Visiting: Dr Nils Wedi, Dr Christan Kühnlein & Prof Piotr Smolarkiewicz, ECMWF (European Centre for Medium-Range Weather Forecasts)</span>
        </a>
        <div id="collapse-srv1" class="accordion-body collapse padding">
            <p>
                ECMWF is currently developing a ground breaking non-hydrostatic atmospheric dynamics Finite Volume Module (FVM)
                which will be implemented in the ECMWF’s Integrated Forecasting System (IFS). 
                The IFS is the operational tool used to provide medium range weather prediction services for the UK and most EU countries. 
            </p>
            <p>
                Many aspects of the spatial discretisation employed in the FVM originated from Dr Szmelter’s earlier 
                work on unstructured mesh models for fluid flows. In recent years, these have been substantially advanced 
                by ECMWF to take advantage of the IFS environment and High Performance Computing.
            </p>
            <p>
                The main goal of the SRV is to discuss and initiate the implementation of an alternative discretisation 
                of selected operators, which could potentially offer further improvements to the module in terms of accuracy and speed.
                Suitable numerical tests will be defined and set up. Dr Szmelter will also explore whether some of the 
                advancements achieved for atmospheric flows in the FVM could be applied to other engineering and environmental flows.
            </p>
        </div>
        @if (false)
        <button class="btn btn-default" data-toggle="modal"
                data-target="#srv-1">
            Summary
        </button>
        <div class="modal fade" style="margin-top: 10%;"
             id="srv-1" role="dialog" arial-labelledby="label-srv1">
          <div class="modal-dialog" role="document" style="min-width: 60%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        arial-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="label-srv1">
                    Advancing Atmospheric Models: Aspects of Spatial Discretisation
                </h4>
              </div>
              <div id="body-srv1" class="modal-body">
              </div>
            </div>
          </div>
        </div>
        @endif
    </div>
  
        <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv2" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
            <i ng-class="{'glyphicon-chevron-up': isCollapsed, 'glyphicon-chevron-down': !isCollapsed}" class='glyphicon pull-right'></i>

        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                Controlling nematic microfluidics: a merger of modelling, simulation and experiments
            </div>
        </span>
        
        <span class="talks-speaker display-block">Dr Apala Majumdar</span>
        <span class="display-block">Department of Mathematical Sciences</span>
        <span class="display-block line-break">University of Bath</span>
        <span class="display-block line-break">Visiting: Dr Ian Griffiths (Mathematical Institute, University of Oxford)</span>
        </a>
        <div id="collapse-srv2" class="accordion-body collapse padding">
            <p>
                Nematic liquid crystals (NLCs) are complex non-Newtonian fluids – anisotropic fluids with a degree of 
                long-range orientational ordering. A rapidly growing research theme concerns “nematic microfluidics” or 
                the flow of NLCs confined to thin channels. Experimentalists are keen to exploit nematic microfluidics 
                for new applications in hydrodynamics, transport phenomena and next-generation pharmaceutical applications such as drug delivery.
            </p>
            <p>
                The introduction of nanoparticles into NLCs modifies the fluid properties, and understanding this effect 
                may lead to new applications. Some earlier collaborative work between Drs Majumdar and Griffiths on the 
                flow of nanoparticles in nematic microfluidics showed interesting effects, especially in cases with multiple nanoparticles. 
            </p>
            <p>
                The SRV will therefore focus primarily on the flow of nanoparticles in nematic microfluidics, 
                and through a combination of modelling, simulation and experiments, will address issues such as: 
            <ul>
                <li>how the nanoparticles interact with the fluid flow and the nematic orientation, and vice-versa;</li>
                <li>how this interaction can be manipulated to produce desired agglomerates with desired properties;</li>
                <li>how the shape and size of nanoparticles can be varied to manipulate the rheology;</li>
                <li>assessing the predictions of different mathematical theories for nematodynamics and how they compare to experiments.</li>
            </ul>
            </p>
        </div>
        @if (false)
        <button class="btn btn-default" data-toggle="modal"
        data-target="#srv-2">
            Summary
        </button>
        <div class="modal fade" style="margin-top: 10%;"
             id="srv-2" role="dialog" arial-labelledby="label-srv2">
          <div class="modal-dialog" role="document" style="min-width: 60%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        arial-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="label-srv2">
                    Controlling nematic microfluidics: a merger of modelling, simulation and experiments
                </h4>
              </div>
              <div id="body-srv2" class="modal-body">
              </div>
            </div>
          </div>
        </div>
        @endif
    </div>
  
    <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv3" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
            <i ng-class="{'glyphicon-chevron-up': isCollapsed, 'glyphicon-chevron-down': !isCollapsed}" class='glyphicon pull-right'></i>

        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                Exploration of integrated microfluidics with phononics and acoustofluidics based on thin-film platform
            </div>
        </span>
        
        <span class="talks-speaker display-block">Dr Richard Fu</span>
        <span class="display-block">Department of Maths, Physics and Electrical Engineering</span>
        <span class="display-block line-break">Northumbria University</span>
        <span class="display-block line-break">Visiting: Dr Julien Reboud & Dr Rab Wilson (University of Glasgow)</span>
        </a>
        <div id="collapse-srv3" class="accordion-body collapse padding">
            <p>
                The SRV will initiate proof-of-concept collaborative work to develop phononic structures (Glasgow) on 
                thin-film ZnO surface acoustic wave devices (Northumbria). This has the potential of creating ultra-low-cost 
                acoustofluidics devices, capable of carrying out complex microfluidic processing of samples for applications 
                in flexible and wearable healthcare monitoring. Dr Fu will fabricate and test different designs of acoustofluidic device.
            </p>
            <p>
                Prior to the SRV, suitable ZnO-coated substrate samples will be prepared at Northumbria, 
                while Glasgow will carry out calculations to confirm the microstructure geometry to be used. Then:
                <ul>
                    <li>
                        In the James Watt Nanofabrication Centre at Glasgow, different phononic structures (pillars or holes) 
                        will be patterned and fabricated on the ZnO-film-coated substrates
                    </li>
                    <li>The ultrasonic surface vibration patterns will be validated using a high-frequency laser Doppler vibrometer (frequency range in the 10’s of MHz)</li>
                    <li>
                        The microfluidic performance of fabricated devices will be tested using (i) conventional microfluidic test beds to look at streaming, 
                        flowing, jetting and nebulisation; and (ii) a high-frame-rate camera (up to 1MHz)
                    </li>
                </ul>
            </p>
            <p>
                Following the SRV, the data will be used in support of new collaborative research bids, and in discussions 
                with interested industrial partners who could develop microfluidics products for healthcare applications.
            </p>
        </div>
        @if (false)
        <button class="btn btn-default" data-toggle="modal"
        data-target="#srv-3">
            Summary
        </button>
        <div class="modal fade" style="margin-top: 10%;"
             id="srv-3" role="dialog" arial-labelledby="label-srv3">
          <div class="modal-dialog" role="document" style="min-width: 60%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        arial-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="label-srv3">
                    Exploration of integrated microfluidics with phononics and acoustofluidics based on thin-film platform
                </h4>
              </div>
              <div id="body-srv3" class="modal-body">
              </div>
            </div>
          </div>
        </div>
        @endif
    </div>
    
    <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv4" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
            <i ng-class="{'glyphicon-chevron-up': isCollapsed, 'glyphicon-chevron-down': !isCollapsed}" class='glyphicon pull-right'></i>

        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                Interrogating local shear effects on coherent structure identification in turbulent flows
            </div>
        </span>
        
        <span class="talks-speaker display-block">Dr Chris Keylock</span>
        <span class="display-block"Department of Civil and Structural Engineering</span>
        <span class="display-block line-break">University of Sheffield</span>
        <span class="display-block line-break">Visiting: Dr Oliver Buxton (Department of Aeronautics, Imperial College, London)</span>
        </a>
        <div id="collapse-srv4" class="accordion-body collapse padding">
            <p>
                Dr Buxton has obtained three-dimensional experimental data on the behaviour of various turbulent flows 
                (boundary layers, wakes, shear layers). With 3D data, the full velocity gradient tensor is available for 
                analysis, and we will apply various vortex identification schemes to extract flow structure information. 
                However, most of these methods are eigenvalue-based, so we will also derive complementary methods that 
                incorporate effects excluded from consideration in an eigenvalue-based approach. Hence, we will be able 
                to identify structures that are clear in both types of approach, as well as those that are better 
                represented in one than the other. We will then seek to explain these differences in terms of local 
                energy production and dissipation. Such analyses will inform the physical basis for future turbulence closures.
            </p>
        </div>
        @if (false)
        <button class="btn btn-default" data-toggle="modal"
        data-target="#srv-4">
            Summary
        </button>
        <div class="modal fade" style="margin-top: 10%;"
             id="srv-4" role="dialog" arial-labelledby="label-srv4">
          <div class="modal-dialog" role="document" style="min-width: 60%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        arial-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="label-srv4">
                    Interrogating local shear effects on coherent structure identification in turbulent flows
                </h4>
              </div>
              <div id="body-srv4" class="modal-body">
              </div>
            </div>
          </div>
        </div>
        @endif
    </div>
  
    <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv5" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
            <i ng-class="{'glyphicon-chevron-up': isCollapsed, 'glyphicon-chevron-down': !isCollapsed}" class='glyphicon pull-right'></i>

        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                Towards a mechanistic understanding of haematocrit changes in tumour vasculature
            </div>
        </span>
        
        <span class="talks-speaker display-block">Dr Miguel O. Bernabeu</span>
        <span class="display-block">Centre for Medical Informatics</span>
        <span class="display-block line-break">The University of Edinburgh</span>
        <span class="display-block line-break">Visiting: Prof Helen Byrne (Mathematical Institute, University of Oxford)</span>
        </a>
        <div id="collapse-srv5" class="accordion-body collapse padding">
            <p>
                Several authors have reported anomalous blood flow patterns in tumour vasculature, including deviations 
                from the typical haematocrit (red blood cell count) distributions observed in healthy tissue. 
                Such abnormalities present a challenge for drug delivery and have been linked to tumour hypoxia and angiogenesis.
            </p>
            <p>
                To date, most computational models of tumour blood flow view the blood as a homogeneous fluid and employ 
                phenomenological rules to determine haematocrit changes at vessel bifurcations. Such models fail to capture 
                the dynamics encountered in tumours. This is, in part, due to the computational challenges associated with 
                simulating haematocrit changes in a mechanistic way, i.e. using a model of interacting deformable particles 
                to describe the transport of red blood cells (RBCs) in the plasma.
            </p>
            <p>
                The SRV will initiate a collaboration between the groups of Prof Byrne and Dr Bernabeu to exploit their complementary expertise:
                <ul>
                    <li>
                        Prof Byrne and colleagues have considerable experience of simulating blood flow and oxygen 
                        distribution in tumours and have recently developed a microfluidics assay that recapitulates RBC dynamics in tumour vascular networks.
                    </li>
                    <li>
                        Dr Bernabeu and colleagues have recently extended HemeLB, their blood flow simulation platform 
                        that treats blood as a suspension of red blood cells 
                        (<a href="http://www.archer.ac.uk/community/eCSE/eCSE01-010/eCSE01-010.php">http://www.archer.ac.uk/community/eCSE/eCSE01-010/eCSE01-010.php)</a>.
                    </li>
                </ul>
            </p>
            <p>
                The SRV will focus on constructing and validating computational models of blood flow in realistic tumour 
                microvasculature, based on experimental data recently obtained by Prof Byrne and colleagues. These models 
                will be used to develop a mechanistic model of haematocrit changes.
            </p>
        </div>
        @if (false)
        <button class="btn btn-default" data-toggle="modal"
        data-target="#srv-5">
            Summary
        </button>
        <div class="modal fade" style="margin-top: 10%;"
             id="srv-5" role="dialog" arial-labelledby="label-srv5">
          <div class="modal-dialog" role="document" style="min-width: 60%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        arial-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="label-srv5">
                    Towards a mechanistic understanding of haematocrit changes in tumour vasculature
                </h4>
              </div>
              <div id="body-srv5" class="modal-body">
              </div>
            </div>
          </div>
        </div>
        @endif
    </div>
  
  
      <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv6" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
          
        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                Effect of surfactant re-distribution on the flow and stability of foam films
            </div>
        </span>
        
        <span class="talks-speaker display-block">Dr Denny Vitasari</span>
        <span class="display-block">Institute of Mathematics, Physics and Computer Science</span>
        <span class="display-block line-break">Aberystwyth University</span>
        <span class="display-block line-break">Visiting: Dr Paul Grassia & Mr Ruben Rosario, University of Strathclyde</span>
        </a>
        <div id="collapse-srv6" class="accordion-body collapse padding">
            <p>
                Soap films are thin interfaces containing fluid and (stabilising) surfactant molecules. Not only is predicting the flow within them difficult, but predicting how they move is also technically challenging, yet it is significant in industrial applications such as oil recovery, medical products, and soil remediation.
            </p>
            <p>
               The viscous froth model (VFM), which balances film curvature and adjacent bubble pressures with the friction experienced by the film, has been used to predict the foam flow in constricted narrow channel. However, it suffers from the simplifying assumption of constant surface tension along the film.
            </p>
            <p>
               Gradients of surface tension develop along expanding/contracting films during flow, altering the force balance and changing foam flow rate and film stability. The Strathclyde group is currently developing surfactant transport models that will be included in the VFM.
            </p>
            <p>
                The SRV will allow Dr Vitasari to discuss with Dr Grassia and Mr Rosario the implementation of their model in the VFM and hence to assess the effect of surfactant movement on foam flow and film stability, leading to joint journal publications and contribution to foam oil recovery process designs.
            </p>
        </div>
      </div>
  
      <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv7" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
          
        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                Modelling sediment transport in an integrated free-surface and subsurface water flow framework
            </div>
        </span>
        
        <span class="talks-speaker display-block">Dr Dongfang Liang</span>
        <span class="display-block">Department of Engineering, Division of Civil Engineering</span>
        <span class="display-block line-break">University of Cambridge</span>
        <span class="display-block line-break">Visiting: Prof Simon Tait & Dr Songdong Shao, University of Sheffield</span>
        </a>
        <div id="collapse-srv7" class="accordion-body collapse padding">
            <p>
                Traditionally, only the bed shear is considered as the driving force for sediment transport. Very little research has been reported concerning the influence of both the shear stress at the soil/water interface and the hydraulic gradient within the soil layer on the sediment motion.
            </p>
            <p>
               The visit will focus on research to develop a novel sediment transport model using a Lagrangian computational technique. A dynamically-integrated free-surface and subsurface flow model will be developed using the SPH (Smoothed Particle Hydrodynamics) method, which will enable the inclusion of the contributions of both the bed shear stress and the seepage force to sediment transport. The developed model will be used to model the flow and scour around offshore pipelines to demonstrate its superiority over existing scour modelling techniques.
            </p>
        </div>
    </div>
  
      <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv8" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
          
        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                Positron Emission Particle Tracking (PEPT) measurements of silo honking
            </div>
        </span>
        
        <span class="talks-speaker display-block">Dr Nathalie Vriend</span>
        <span class="display-block">Department of Applied Mathematics and Theoretical Physics</span>
        <span class="display-block line-break">University of Cambridge</span>
        <span class="display-block line-break">Visiting: Dr Kit Windows-Yule, University of Birmingham</span>
        </a>
        <div id="collapse-srv8" class="accordion-body collapse padding">
            <p>
                Silo honking is the harmonic sound generated by the discharge of a silo filled with a granular material. Previous work by Dr Vriend’s research group focused on the characterization of sound with high-fidelity microphones and capturing high-speed imagery of the moving particles through the side walls. The motion of particles touching the side walls, where the highest friction occurs, shows a fascinating pattern in space and time, but the behaviour of internal grains remains a mystery due to their inaccessibility for imaging.
            </p>
            <p>
               The PEPT facility allows the real-time tracking of a radioactive tracer particle inside a sand-filled tube 2m long, with a 30x30cm section, at sub-millimetre spatial resolution and millisecond-scale temporal resolution. The particle is labelled in such a manner that is remains physically identical to all others within the system, making PEPT an entirely non-intrusive and non-destructive technique.
            </p>
            <p>
                As PEPT imaging utilises high-energy (511 keV) gamma-rays, single-particle motion can be observed even deep within the bulk of large, dense and opaque systems, with a temporal resolution that cannot be achieved using more conventional tomographic techniques.
            </p>
            <p>
                By repeating the experiment at different heights and positions in the tube, it is possible to extract full three-dimensional flow fields, in addition to numerous other single-particle and whole-field quantities, thereby providing critical and novel information for modelling silo honking.
            </p>
        </div>
    </div>
  
      <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv9" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
          
        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                The nature of secondary flows in turbulent boundary layers over rough beds
            </div>
        </span>
        
        <span class="talks-speaker display-block">Dr Marco Placidi</span>
        <span class="display-block">City, University of London</span>
        <span class="display-block line-break">Visiting: Prof Bharathram Ganapathisubramani & Dr Christina Vanderwel, University of Southampton</span>
        </a>
        <div id="collapse-srv9" class="accordion-body collapse padding">
            <p>
                Evidence has been collected on the existence of large-scale secondary motions in turbulent boundary layer developing over disparate roughness types. These Secondary Flows (SFs) modulate the mean flow, generating high- and low-momentum pathways, which in turn contribute to sediment transport, drag and heat transfer. Despite the importance and relevance of SFs in a variety of natural environments and engineering applications, their nature and genesis remain largely unclear. 
            </p>
            <p>
               This short research visit will focus on carrying out a series of controlled experiments to shed light on the physics of the generation of secondary motions in turbulent boundary layers developing over different rough topologies. This fundamental project aims at paving the way toward a deeper understanding of rough-wall physics. 3D Stereoscopic Particle Image Velocimetry data will be acquired on novel highly rough surfaces, which will include: (i) regular longitudinal roughness strips of 'infinitesimal' width and (ii) alternating spanwise strips of smooth and rough surfaces.
            </p>
        </div>
    </div>

  
      <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv10" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
          
        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                The stability and transition of rotating flows as applied to Chemical Vapour Deposition
            </div>
        </span>
        
        <span class="talks-speaker display-block">Mr Robert Miller</span>
        <span class="display-block">Department of Engineering</span>
        <span class="display-block">University of Leicester</span>
        <span class="display-block line-break">Visiting: Dr Zahir Hussain, Manchester Metropolitan University; Prof Jitesh Gajjar, University of Manchester</span>
        </a>
        <div id="collapse-srv10" class="accordion-body collapse padding">
            <p>
                Chemical Vapour Deposition is a micro-fabrication process for growing epitaxial films a very few atoms thick. A reactant gas is pumped into a high temperature environment that fractures it into its constituent atoms and deposits them along a substrate. Limited prior work has been done that models the gas in a rotating-pedestal reactor as a modification to von Kármán flow. There is growing interest in whether the transitional boundary-layer flows present could hinder film growth; however, a comprehensive model has not yet been developed.  
            </p>
            <p>
               The applicant’s research aims to use modern stability techniques to develop a model of strong interest to the CVD community, and the SRV will make links with the CVD community and explore the limitations of the previous models by:
            <ul>
                <li>Forging meaningful links with CVD researchers at MMU and discuss in depth different reactor designs and operations</li>
                <li>Identifying current fluid issues within CVD and how they might be modelled</li>
                <li>Further developing links with Dr Hussain and Prof Gajjar, authors of prior stability analyses of direct relevance</li>
                <li>Presenting analytical work to date to a non-fluids community</li>
            </ul>
            </p>
        </div>
    </div>

  
      <div class="panel panel-default line-break-dbl">
        <a href="#collapse-srv11" data-toggle="collapse" class="noborder list-group-item talk panel-body accordion-toggle">
          
        <span class="text-danger display-block">
            <div class="panel-title line-break-half">
                Viscous froth and surfactant mass transfer
            </div>
        </span>
        
        <span class="talks-speaker display-block">Mr Ruben Rosario</span>
        <span class="display-block">Department of Chemical and Process Engineering</span>
        <span class="display-block line-break">University of Strathclyde</span>
        <span class="display-block line-break">Visiting: Dr Denny Vitasari, Ms Francesca Zaccagnino & Prof Simon Cox, Aberystwyth University</span>
        </a>
        <div id="collapse-srv11" class="accordion-body collapse padding">
            <p>
                Surfactant mass transfer mechanisms in foam films, in the context of foam fractionation, include convective Marangoni flows along film surfaces that occur when foam films expand or shrink while moving through a channel, coupled with film drainage effects and mobile interfaces, changing the surfactant concentration on the interfaces and thus their surface tension. The associated film deformations have a direct impact on the viscous froth model, being developed by the Aberystwyth group, and so need to be considered to produce a more realistic model for foam flows.
            </p>
            <p>
               This SRV represents an excellent networking opportunity and a chance to understand how the applicant’s current work on surfactant mass transfer mechanisms can be adapted to the deforming foam films studied by Prof Cox’s group. The SRV will also facilitate knowledge exchange between the foam modelling groups in the University of Strathclyde and Aberystwyth University, focusing on the inclusion of surfactant mass transfer mechanisms on bubble interfaces, to estimate better the film surface tension used in the viscous froth model of foams flowing in microfluidic channels.
            </p>
            <p>
                This project can have great impact in a wide range of industries using foams in microfluidic channels, including medical, pharmaceutical, biological and oil recovery fields, as well as contaminated soil remediation.
            </p>
        </div>
    </div>
  
@endsection
