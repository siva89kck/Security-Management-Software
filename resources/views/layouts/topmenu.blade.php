<header class="header-main">
          <div class="container-fluid">
            <div class="row">
              <div class="col-6 col-sm-4 d-flex align-items-center header-left p-0">
                <span class="header-toggle me-3">
                  <i class="ph ph-circles-four"></i>
                </span>
              </div>

              <div class="col-6 col-sm-8 d-flex align-items-center justify-content-end header-right p-0">

                <ul class="d-flex align-items-center">
                  <li class="header-dark">
                    <div class="sun-logo head-icon">
                      <i class="ph ph-moon-stars"></i>
                    </div>
                    <div class="moon-logo head-icon">
                      <i class="ph ph-sun-dim"></i>
                    </div>
                  </li>
                  <li class="header-profile">
                    <a href="#" class="d-block head-icon" role="button" data-bs-toggle="offcanvas"
                      data-bs-target="#profilecanvasRight" aria-controls="profilecanvasRight">
                      <img src="{{ asset('assets/images/avtar/woman.jpg') }}" alt="avtar" class="b-r-10 h-35 w-35">
                    </a>

                    <div class="offcanvas offcanvas-end header-profile-canvas" tabindex="-1" id="profilecanvasRight"
                      aria-labelledby="profilecanvasRight">
                      <div class="offcanvas-body app-scroll">
                        <ul class="">
                          <li>
                            <div class="d-flex-center">
                              <span class="h-45 w-45 d-flex-center b-r-10 position-relative">
                                <img src="{{ asset('assets/images/avtar/woman.jpg') }}" alt="" class="img-fluid b-r-10">
                              </span>
                            </div>
                            <div class="text-center mt-2">
                              <h6 class="mb-0"> {{ Auth::user()->name }}</h6>
                              <p class="f-s-12 mb-0 text-secondary">{{ Auth::user()->email }}</p>
                            </div>
                          </li>

                          <li class="app-divider-v dotted py-1"></li>
                          <li>
                            <a class="f-w-500" href="{{ url('profile') }}" target="">
                              <i class="ph-duotone  ph-user-circle pe-1 f-s-20"></i> Profile Details
                            </a>
                          </li>
                          <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="mb-0 text-danger bg-transparent border-0">
                                <i class="ph-duotone  ph-sign-out pe-1 f-s-20"></i> Log Out</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </header>
