@extends('layouts.app')
@section('working_hour_nav', 'active')
@section('title', 'Category')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Working Hours</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item "><a href="{{route('working_hour.index')}}">Working Hours</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card card-primary ">
                        <div class="card-header">
                            <h3 class="card-title">Add Working Hours</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ route('working_hour.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group ">
                                    <label for="day">Day</label>
                                    <select id="day" class="form-control" name="day">
                                        <option value="">Choose...</option>
                                        <option value="monday">Monday</option>
                                        <option value="tuesday">Tuesday</option>
                                        <option value="wednesday">Wednesday</option>
                                        <option value="thursday">Thursday</option>
                                        <option value="friday">Friday</option>
                                        <option value="saturday">Saturday</option>
                                        <option value="sunday">Sunday</option>
                                    </select>
                                </div>
                                {{--                                <div class="form-group ">--}}
                                {{--                                    <label for="opening_time">Opening Hour</label>--}}
                                {{--                                    <input type="text" value="{{old('opening_time')}}"--}}
                                {{--                                           class="form-control {{ $errors->has('opening_time') ? ' is-invalid' : ''}}"--}}
                                {{--                                           name="opening_time" id="opening_time" placeholder="Enter"/>--}}
                                {{--                                    @if($errors->has('opening_time'))--}}
                                {{--                                        <span class="invalid-feedback" role="alert">--}}
                                {{--                                    <strong>{{ $errors->first('opening_time') }}</strong>--}}
                                {{--                                </span>--}}
                                {{--                                    @endif--}}
                                {{--                                </div>--}}

                                <div class="form-group ">
                                    <label for="opening_time">Open Timing</label>
                                    <select id="opening_time" class="form-control" name="opening_time">
                                        <option value="">Choose...</option>
                                        <option value="0:00:00">0:00:00</option>
                                        <option value="1:00:00">1:00:00</option>
                                        <option value="2:00:00">2:00:00</option>
                                        <option value="3:00:00">3:00:00</option>
                                        <option value="4:00:00">4:00:00</option>
                                        <option value="5:00:00">5:00:00</option>
                                        <option value="6:00:00">6:00:00</option>
                                        <option value="7:00:00">7:00:00</option>
                                        <option value="8:00:00">8:00:00</option>
                                        <option value="9:00:00">9:00:00</option>
                                        <option value="10:00:00">10:00:00</option>
                                        <option value="11:00:00">11:00:00</option>
                                        <option value="12:00:00">12:00:00</option>
                                        <option value="13:00:00">13:00:00</option>
                                        <option value="14:00:00">14:00:00</option>
                                        <option value="15:00:00">15:00:00</option>
                                        <option value="16:00:00">16:00:00</option>
                                        <option value="17:00:00">17:00:00</option>
                                        <option value="18:00:00">18:00:00</option>
                                        <option value="19:00:00">19:00:00</option>
                                        <option value="20:00:00">20:00:00</option>
                                        <option value="21:00:00">21:00:00</option>
                                        <option value="22:00:00">22:00:00</option>
                                        <option value="23:00:00">23:00:00</option>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="closing_time">Closing Timing</label>
                                    <select id="closing_time" class="form-control" name="closing_time">
                                        <option value="">Choose...</option>
                                        <option value="0:00:00">0:00:00</option>
                                        <option value="1:00:00">1:00:00</option>
                                        <option value="2:00:00">2:00:00</option>
                                        <option value="3:00:00">3:00:00</option>
                                        <option value="4:00:00">4:00:00</option>
                                        <option value="5:00:00">5:00:00</option>
                                        <option value="6:00:00">6:00:00</option>
                                        <option value="7:00:00">7:00:00</option>
                                        <option value="8:00:00">8:00:00</option>
                                        <option value="9:00:00">9:00:00</option>
                                        <option value="10:00:00">10:00:00</option>
                                        <option value="11:00:00">11:00:00</option>
                                        <option value="12:00:00">12:00:00</option>
                                        <option value="13:00:00">13:00:00</option>
                                        <option value="14:00:00">14:00:00</option>
                                        <option value="15:00:00">15:00:00</option>
                                        <option value="16:00:00">16:00:00</option>
                                        <option value="17:00:00">17:00:00</option>
                                        <option value="18:00:00">18:00:00</option>
                                        <option value="19:00:00">19:00:00</option>
                                        <option value="20:00:00">20:00:00</option>
                                        <option value="21:00:00">21:00:00</option>
                                        <option value="22:00:00">22:00:00</option>
                                        <option value="23:00:00">23:00:00</option>
                                    </select>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a style="float:right; margin:0 5px;" href="{{ route('working_hour.index') }}"
                                       class="btn btn-secondary btn-sm">Cancel</a>
                                    <button type="submit" class="btn btn-primary btn-sm"
                                            style="float:right;">Add
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
{{-->>>>>>> ff096d4b12bff8b424f347de443c0ea84fcf26cd--}}
