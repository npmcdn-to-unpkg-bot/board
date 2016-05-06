@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid no-padding work-zone">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 sub-nav-wrapper">
                                <ul class="sub-nav">
                                    <li><a href="#/adverts">Все объявления</a></li>
                                    <li><a href="#/adverts/my">Мои объявления</a></li>
                                    <li><a href="#/adverts/add">Добавить объявление</a></li>
                                    <li><a href="#/offers/my">Мои предложения</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-10 col-md-9 ng-pan">
                                <div class="ng-content-box">
                                    <div data-ng-view></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
