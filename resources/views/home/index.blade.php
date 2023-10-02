@extends('layouts.new_app')

@section('title', $title ?? __("Mukhya Mantri Swavalamban Yojana"))

@section('contents')
    {{-- @include('shared.front-end.slider')
    @include('shared.front-end.mmsy_tips')
    @include('shared.front-end.our_schemes')
    @include('shared.front-end.commitee')
    @include('shared.front-end.aboutus')
    @include('shared.front-end.details')
    @include('shared.front-end.important_lnks') --}}
    @include('shared.front-end.new_header')
  @include('shared.front-end.tabs-section')


    
<style>
  .nav-pills .nav-link.active
    {
        background-color: #727272!important; 
        width: 100%!important;
       
        
    }
    #v-pills-tab .nav-link:hover
    {
        background-color: #727272!important; 
        width: 100%!important;
       
    }
    #v-pills-hn-tab,#v-pills-n-tab,#v-pills-nol-tab,#v-pills-ff-tab,#v-pills-fr-tab,#v-pills-faq-tab,#v-pills-g-tab
  {

  column-gap: 15px;
  display: flex;
  color: #010101;
  font-size: 16px;
  font-weight: 400!important;
  margin: 20px 0px !important;
  }

  .main_mmsy img
  {
      width: 50px!important;
  }
      .wrapper{
        margin-bottom: 30px;
      }
      .mmsy_outer{
        width: 100%
      }
      .caution
      {
      width: 100%;
      height: auto;
      margin: 2rem 0 0.8rem 0;
      position: relative;
      border: 1px solid #198754;
      }
      .caution-main
      {
      background-color: #E36E2C;
      width: 100%;
      height: auto;
      padding-bottom: 1.1rem;
    }
    .caution .caution-main .caution-head 
    {
      padding: 7px 15px 0px 15px;
      width: auto;
      height: 2.2rem;
      background-color: #198754;
      border: 1px solid #198754;
      border-radius: 15px;
      position: absolute;
      top: 0px;
      left: 50%;
      transform: translate(-50%,-50%);
  }
  .caution-main .caution-head h5
  {
      color: #fff;
      font-size: 15px;
  }
  .caution-notice 
  {
      padding: 0 0.5rem;
      width: auto;
      height: auto;
  }
  .caution-notice p 
  {
      text-align: center;
      padding-top: 2.2rem;
      color: #fff
  }
  button.nav-link{
    display: flex;
    align-items: center;
    width: 100%;
  }
  .nav a{
    text-decoration: none;
  }
</style>
@endsection
