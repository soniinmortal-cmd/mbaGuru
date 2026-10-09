@extends('admin_template')

@section('css')
@endsection

@section('content')
    <div class="col-md-9 bg-light py-3 " id="right-menu-bar">
        <div id="topbar-right-menu " class="d-flex  px-4 my-3 justify-content-between align-items-center">
            <h5 class="fw-bold text-capitalize">Propzone</h5>
        </div>

        <!-- box image styling starts  -->
        <div class="conatiner">
            <div class="row px-3 Propzone" id="card-img-style-box">
                <div class="col-md-3">

                    <div class="card border-0 mx-auto card-img-style " style="background-color: white;">
                        <div class="card-header bg-none py-1  border-0 fs-6 fw-normal" style="color:#808191!important">Score
                        </div>
                        <div class="card-body py-1 ">
                            <h5 class="card-title" style="position: relative;color: #11142D;">
                                <span class="spinner spinner1"> </span>
                                5,732
                            </h5>
                            <p class="card-text">

                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                        <div class="card-header bg-none py-1  border-0 fs-6 fw-normal" style="color:#808191!important">
                            Negative Marks</div>
                        <div class="card-body py-1 ">
                            <h5 class="card-title" style="position: relative;color: #11142D;">
                                <span class="spinner spinner2"> </span>2
                            </h5>
                            <p class="card-text">

                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                        <div class="card-header bg-none py-1 border-0 fs-6 fw-normal" style="color:#808191!important"> Avg
                            time per Question (sec) </div>
                        <div class="card-body py-1 ">
                            <h5 class="card-title" style="position: relative;color: #11142D;">
                                <span class="spinner spinner3"> </span>
                                5,732
                            </h5>
                            <p class="card-text">

                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="card border-0 mx-auto card-img-style" style="background-color: white;">
                        <div class="card-header bg-none py-1  border-0 fs-6 fw-normal" style="color:#808191!important">
                            Accuracy %</div>
                        <div class="card-body py-1 ">
                            <h5 class="card-title" style="position: relative;color: #11142D;">
                                <span class="spinner spinner4"> </span>
                                5,732
                            </h5>
                            <p class="card-text">

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- box image  styling end  -->

        <!-- button group styling  styling start  -->

        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="mt-5 mb-3 px-2" id="button-group">
                        <button type="button" class="btn btn-primary active"
                            style="color:#808191;background-color: white;">Area level</button>
                        <button type="button" class="btn btn-secondary"
                            style="color:#808191;background-color: white;">Topic level</button>
                        <button type="button" class="btn btn-success"
                            style="color:#808191;background-color: white;">Difficulty level</button>
                        <button type="button" class="btn btn-danger"
                            style="color:#808191;background-color: white;">Solution</button>

                    </div>
                </div>
            </div>
        </div>
        <!-- button group styling  styling end  -->

        <!-- display box styling starts-->

        <div class="container">
            <div class="row px-2 my-5">
                <div class="col-md-12 px-2 my-2">
                    Scoredcard
                </div>
                <div class="col-md-12 px-2">
                    <div class="card bg-white py-3 px-1 display-box-data">
                        <table class="table w-100">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th> Questions </th>
                                    <th>Time takesn</th>
                                    <th>Attempt</th>
                                    <th>Correct</th>
                                    <th>Incorrect</th>
                                    <th>Skipped</th>
                                    <th>Score</th>
                                    <th>Accuracy%</th>
                                    <th>Precentile</th>
                                    <th>Cut Off</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>All section</td>
                                    <td>76</td>
                                    <td>01:29:45</td>
                                    <td>76 <br> (01:29:45)</td>
                                    <td>69 <br>(01:29:45)</td>
                                    <td>8 <br>(01:29:45)</td>
                                    <td>0 <br>(01:29:45)</td>
                                    <td>198.00</td>
                                    <td>89.47</td>
                                    <td>-</td>
                                    <td>61</td>
                                </tr>
                                <tr>
                                    <td>All section</td>
                                    <td>76</td>
                                    <td>01:29:45</td>
                                    <td>76 <br> (01:29:45)</td>
                                    <td>69 <br>(01:29:45)</td>
                                    <td>8 <br>(01:29:45)</td>
                                    <td>0 <br>(01:29:45)</td>
                                    <td>198.00</td>
                                    <td>89.47</td>
                                    <td>-</td>
                                    <td>61</td>
                                </tr>
                                <tr>
                                    <td>All section</td>
                                    <td>76</td>
                                    <td>01:29:45</td>
                                    <td>76 <br> (01:29:45)</td>
                                    <td>69 <br>(01:29:45)</td>
                                    <td>8 <br>(01:29:45)</td>
                                    <td>0 <br>(01:29:45)</td>
                                    <td>198.00</td>
                                    <td>89.47</td>
                                    <td>-</td>
                                    <td>61</td>
                                </tr>
                                <tr>
                                    <td>All section</td>
                                    <td>76</td>
                                    <td>01:29:45</td>
                                    <td>76 <br> (01:29:45)</td>
                                    <td>69 <br>(01:29:45)</td>
                                    <td>8 <br>(01:29:45)</td>
                                    <td>0 <br>(01:29:45)</td>
                                    <td>198.00</td>
                                    <td>89.47</td>
                                    <td>-</td>
                                    <td>61</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12 px-2 mt-5 mb-2">

                    Question Summary
                </div>
                <div class="col-md-12 px-2">
                    <div class="card bg-white py-3 px-1 mb-3 display-box-data">
                        <table class="table w-100 ">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th> Subject </th>
                                    <th>Area</th>
                                    <th>Topic</th>
                                    <th>Difficulty Level</th>
                                    <th>Time Taken</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>1.</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Difficult</td>
                                    <td>01:29:45</td>
                                    <td><span><i class="fa fa-check-circle" aria-hidden="true"></i></span></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Difficult</td>
                                    <td>01:29:45</td>
                                    <td><span><i class="fa fa-check-circle" aria-hidden="true"></i></span></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Difficult</td>
                                    <td>01:29:45</td>
                                    <td><span><i class="fa fa-check-circle" aria-hidden="true"></i></span></td>
                                </tr>

                                <tr>
                                    <td>4.</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Verbal And <br>
                                        Reading <br>
                                        Comprehension</td>
                                    <td>Difficult</td>
                                    <td>01:29:45</td>
                                    <td><span><i class="fa fa-check-circle" aria-hidden="true"></i></span></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
@endsection
