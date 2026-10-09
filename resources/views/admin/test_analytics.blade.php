@extends('admin_template')

@section('css')
@endsection

@section('content')
    <div class="col-md-9 bg-light py-3 " id="right-menu-bar">
        <div id="topbar-right-menu " class="d-flex  px-4 my-3 justify-content-between align-items-center">
            <h5 class="fw-bold text-capitalize">Test Analytics</h5>
        </div>
        <!-- box image styling starts  -->
        <div class="conatiner">
            <table>
                <thead>
                    <tr>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>MOBILE</th>
                        <th>ADDREDD</th>
                    </tr>
                <thead>
                <tbody>
                    <tr>
                        <td>Center Name</td>
                        <td>test@gmail.com</td>
                        <td>99999999</td>
                        <td>ADDRESS</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
@endsection
