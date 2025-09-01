@extends('layouts.master')
@section('content')
  <!-- Breadcrumb start -->
    <div class="row m-1">
        <div class="col-12">
            <h4 class="main-title">Dashboard</h4>
            <ul class="app-line-breadcrumbs mb-3">
                <li>
                    <a href="{{ route('dashboard') }}" class="f-s-14 f-w-500">
                        <span>
                            <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                        </span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" class="f-s-14 f-w-500">Over View</a>
                </li>
            </ul>
        </div>
    </div>
<div class="row">
              <div class="col-lg-7 col-xxl-6">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="card eshop-cards">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-primary h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-bold  ph-map-pin-line"></i>
                          </span>
                          <div class="dropdown">
                            <a href="#" class="text-primary" role="button" data-bs-toggle="dropdown"
                              aria-expanded="false">
                              Last Month<i class="ti ti-chevron-down ms-1"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end">
                              <li><a class="dropdown-item" href="#">Last Month</a></li>
                              <li><a class="dropdown-item" href="#">Last Week</a></li>
                              <li><a class="dropdown-item" href="#">Last Year</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="flex-shrink-0 align-self-end">
                            <p class="f-s-16 mb-0">Visits</p>
                            <h5>25,220k <span class="f-s-12 text-danger">-45%</span></h5>
                          </div>
                          <div class="visits-chart">
                            <div id="visitsChart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card eshop-cards">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-secondary h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-bold  ph-shopping-cart"></i>
                          </span>
                          <div class="dropdown">
                            <a href="#" class="text-secondary " role="button" data-bs-toggle="dropdown"
                              aria-expanded="false">
                              Weekly<i class="ti ti-chevron-down ms-1"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end">
                              <li><a class="dropdown-item" href="#">Monthly</a></li>
                              <li><a class="dropdown-item" href="#">Weekly</a></li>
                              <li><a class="dropdown-item" href="#">Yearly</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center position-relative">
                          <div class="flex-shrink-0 align-self-end">
                            <p class="f-s-16 mb-0">Order</p>
                            <h5>45,782k <span class="f-s-12 text-success">+65%</span></h5>
                          </div>
                          <div class="order-chart">
                            <div id="orderChart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card eshop-cards">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-success h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-bold  ph-pulse"></i>
                          </span>
                          <div class="dropdown">
                            <a href="#" class="text-success " role="button" data-bs-toggle="dropdown"
                              aria-expanded="false">
                              Today<i class="ti ti-chevron-down ms-1"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end">
                              <li><a class="dropdown-item" href="#">Today</a></li>
                              <li><a class="dropdown-item" href="#">Tomorrow</a></li>
                              <li><a class="dropdown-item" href="#">Last Week</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="flex-shrink-0 align-self-end">
                            <p class="f-s-16 mb-0">Activity</p>
                            <h5>45k</h5>
                          </div>
                          <div class="activity-chart">
                            <div id="activityChart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card eshop-cards">
                      <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-warning h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-fill  ph-coins"></i>
                          </span>
                          <div class="dropdown">
                            <a href="#" class="text-warning " role="button" data-bs-toggle="dropdown"
                              aria-expanded="false">
                              February<i class="ti ti-chevron-down ms-1"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end">
                              <li><a class="dropdown-item" href="#">January</a></li>
                              <li><a class="dropdown-item" href="#">February</a></li>
                              <li><a class="dropdown-item" href="#">March</a></li>
                              <li><a class="dropdown-item" href="#">April</a></li>
                              <li><a class="dropdown-item" href="#">...</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="flex-shrink-0 align-self-end">
                            <p class="f-s-16 mb-0">Sales</p>
                            <h5>$63,987<span class="f-s-12 text-success">+68%</span></h5>
                          </div>
                          <div class="sales-chart">
                            <div id="salesChart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-5 col-xxl-4">
                <div class="card active-user-card">
                  <div class="card-body">
                    <div class="">
                      <h5 class="text-dark">Active Users</h5>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                      <div class="active-user-content">
                        <h2 class="text-primary mb-0">50k</h2>
                        <p class="text-secondary text-nowrap mb-0">Page Views per Minutes</p>
                        <div class="app-divider-v dashed py-3"></div>
                        <p class="f-w-500">Today Users</p>
                        <div>
                          <ul class="avatar-group justify-content-start">
                            <li class="h-35 w-35 d-flex-center b-r-50 overflow-hidden text-bg-primary b-2-light"
                              data-bs-toggle="tooltip" data-bs-title="Sabrina Torres">
                              <img src="../assets/images/avtar/4.png" alt="" class="img-fluid">
                            </li>
                            <li class="h-35 w-35 d-flex-center b-r-50 overflow-hidden text-bg-success b-2-light"
                              data-bs-toggle="tooltip" data-bs-title="Eva Bailey">
                              <img src="../assets/images/avtar/5.png" alt="" class="img-fluid">
                            </li>
                            <li class="h-35 w-35 d-flex-center b-r-50 overflow-hidden text-bg-danger b-2-light"
                              data-bs-toggle="tooltip" data-bs-title="Michael Hughes">
                              <img src="../assets/images/avtar/6.png" alt="" class="img-fluid">
                            </li>
                            <li class="text-bg-secondary h-25 w-25 d-flex-center b-r-50" data-bs-toggle="tooltip"
                              data-bs-title="10 More">
                              10+
                            </li>
                          </ul>
                        </div>
                      </div>
                      <div class="card card-primary flex-grow-1 user-chart-card">
                        <div class="card-body">
                          <div class="active-users-chart">
                            <div id="userChart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="active-users-content mt-3">
                      <div>
                        <h6 class="mb-0">4.78%</h6>
                        <p class="text-secondary mb-0">Monthly</p>
                      </div>
                      <div>
                        <h6 class="mb-0">82.90%</h6>
                        <p class="text-secondary mb-0">Weekly</p>
                      </div>
                      <div>
                        <h6 class="mb-0">80.0%</h6>
                        <p class="text-secondary mb-0">Yearly</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-2 d-none d-xxl-block">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between">
                      <h6 class="header-title-text mb-0">Product Sold </h6>
                      <span><i class="ph-bold  ph-trend-down text-danger"></i></span>
                    </div>
                    <div>
                      <div id="productSold"></div>
                      <div>
                        <a href="product_details.html" target="_blank" role="button" class="btn btn-success w-100">Details</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection

