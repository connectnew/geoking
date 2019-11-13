@extends('layouts.dashboard')

@section('body')

 <div class="row mb-1">
        <div class="col-md-12 col-lg-4 pb-3">
          <div class="active-posts">
            <div class="row">
              <div class="col-9">
                <h1>Active Posts</h1>
                <h2>16</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-pencil-square-o text-white font-30"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-4 pb-3">
          <div class="scheduled-posts">
            <div class="row">
              <div class="col-9">
                <h1>Scheduled Posts</h1>
                <h2>1</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-calendar text-white font-30"></i></div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-4 pb-3">
          <div class="expired-posts">
            <div class="row">
              <div class="col-9">
                <h1>Expired Posts</h1>
                <h2>14</h2>
              </div>
              <div class="col-3 text-right"><i class="fa fa-paper-plane-o text-white font-30"></i></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="bg-white border_2">
            <div class="row mr-0">
              <div class="col-lg-8 col-12 px-10 px-r-0 pr-md-0">
                <div class="w-100 bg-white px-3 h-100 pt-0 pb-3">
                  <div class="row select-sec revews-selectbox">
                    <div class="col py-2">
                      <select class="form-control">
                        <option value="" selected="">Groups</option>
                        <option value="Locations # 1">Groups # 1</option>
                        <option value="Locations # 2">Groups # 2</option>
                        <option value="Locations # 3">Groups # 3</option>
                        <option value="Locations # 4">Groups # 4</option>
                      </select>
                    </div>
                    <div class="col py-2">
                      <select class="form-control">
                        <option value="" selected="">Locations</option>
                        <option value="Locations # 1">Locations # 1</option>
                        <option value="Locations # 2">Locations # 2</option>
                        <option value="Locations # 3">Locations # 3</option>
                        <option value="Locations # 4">Locations # 4</option>
                      </select>
                    </div>
                    <div class="col py-2">
                      <select class="form-control">
                        <option value="" selected="">Sources</option>
                        <option value="Locations # 1">Sources # 1</option>
                        <option value="Locations # 2">Sources # 2</option>
                        <option value="Locations # 3">Sources # 3</option>
                        <option value="Locations # 4">Sources # 4</option>
                      </select>
                    </div>
                    <div class="col py-2">
                      <select class="form-control">
                        <option value="" selected="">Rating</option>
                        <option value="Locations # 1">Rating # 1</option>
                        <option value="Locations # 2">Rating # 2</option>
                        <option value="Locations # 3">Rating # 3</option>
                        <option value="Locations # 4">Rating # 4</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                      <h1 class="reviews-page-title font-weight-normal mb-3 mt-0">My Locations</h1>
                    </div>
                    <div class="col-lg-9 col-sm-6 col-12 mb-lg-0 mb-3"> <span class="float-left float-sm-right">
                      <div class="d-inline-block float-left mt-1 mr-2 text-muted">Heatmap</div>
                      <div class="toggle listing-switch toggle_small d-inline-block float-left mr-2 mt-2">
                        <label class="switch">
                          <input type="checkbox" class="primary" />
                          <span class="slider round"></span> </label>
                      </div>
                      </span> </div>
                  </div>

                  {{-- MAP --}}
                  <main-map :user="{{ Auth::user() }}"></main-map>
                  {{-- <div class="d-block" id="map_div_home_page" style="height: 350px;"> </div> --}}


                </div>
              </div>
              <div class="col-lg-4 col-12 pt-1 px-3 tab-width-set-l bg_light_gray">
                <h1 class="reviews-page-title font-weight-normal mb-0 mt-lg-5 mt-3 pt-lg-2 pt-0"> All Listings Score</h1>
                <div class="row my-5">
                  <div class="col-xllg-7 profile-score-left col-12">
                    <div class="easy-pie-chart-lg-xl box_center">
                      <div id="profile_score" class="chart" data-percent="35"></div>
                      <div class="percent"> <span class="number">35%</span> </div>
                    </div>
                  </div>
                  <div class="col-xllg-5 profile-score-right col-12 mt-lg-3 mt-4">
                    <div class="row">
                      <div class="col-12 col-lg-12 col-sm-4 d-flex align-items-center justify-content-xl-start justify-content-center">
                        <div class="inline-block left-col">
                          <h1>78</h1>
                        </div>
                        <div class="inline-block right-col ml-2">
                          <p class="green-text mb-0"><i class="fa fa-caret-up"></i> 17%</p>
                          <p class="score-text text-uppercase">Total Locations</p>
                        </div>
                      </div>
                      <div class="col-12 col-lg-12 col-sm-4 d-flex align-items-center justify-content-xl-start justify-content-center">
                        <div class="inline-block left-col">
                          <h1>24</h1>
                        </div>
                        <div class="inline-block right-col ml-2">
                          <p class="green-text mb-0"><i class="fa fa-caret-up"></i> 20%</p>
                          <p class="score-text text-uppercase">Fixes Needed</p>
                        </div>
                      </div>
                      <div class="col-12 col-lg-12 col-sm-4 d-flex align-items-center justify-content-xl-start justify-content-center">
                        <div class="inline-block left-col">
                          <h1>12</h1>
                        </div>
                        <div class="inline-block right-col ml-2">
                          <p class="red-text mb-0"><i class="fa fa-caret-down"></i> 18%</p>
                          <p class="score-text text-uppercase">Profile Score</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="d-block bg-white px-3 pt-2">
            <div class="row">
              <div class="col-md-4">
                <p class="reviews-page-title">Review Analysis</p>
              </div>
              <div class="col-md-8">
                <div class="row select-sec revews-selectbox">
                  <div class="col py-2">
                    <select class="form-control">
                      <option value="" selected="">Sources</option>
                      <option value="Sources # 1">Sources # 1</option>
                      <option value="Sources # 2">Sources # 2</option>
                      <option value="Sources # 3">Sources # 3</option>
                      <option value="Sources # 4">Sources # 4</option>
                    </select>
                  </div>
                  <div class="col py-2">
                    <select class="form-control">
                      <option value="" selected="">Period</option>
                      <option value="Period # 1">Period # 1</option>
                      <option value="Period # 2">Period # 2</option>
                      <option value="Period # 3">Period # 3</option>
                      <option value="Period # 4">Period # 4</option>
                    </select>
                  </div>
                  <div class="col py-2">
                    <select class="form-control">
                      <option value="" selected="">Groups</option>
                      <option value="Groups # 1">Groups # 1</option>
                      <option value="Groups # 2">Groups # 2</option>
                      <option value="Groups # 3">Groups # 3</option>
                      <option value="Groups # 4">Groups # 4</option>
                    </select>
                  </div>
                  <div class="col py-2">
                    <select class="form-control">
                      <option value="" selected="">Locations</option>
                      <option value="Locations # 1">Locations # 1</option>
                      <option value="Locations # 2">Locations # 2</option>
                      <option value="Locations # 3">Locations # 3</option>
                      <option value="Locations # 4">Locations # 4</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div id="home_review_analysis" class="mt-2" style="width: 100%; height: 370px"></div>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <div class="row ml-0">
            <div class="col-lg-3 col-xl-2 col-12 bg-gray pt-2 px-3 tab-width-set-r mb-lg-0 mb-3">
              <div class="row">
                <div class="col lh_normal pl-0">
                  <h3 class="font-weight-normal m-0 px-0 py-2 text-center">Performance Trend</h3>
                </div>
              </div>
              <div class="border-bottom mlr_15 mt-2 mt-1"></div>
              <div class="mlr_15">
                <div class="table-responsive">
                  <table class="table performance_tbl">
                    <thead>
                      <tr>
                        <th class="border-top-0 text-left">Location</th>
                        <th class="border-top-0">Reviews</th>
                        <th class="border-top-0">Rating</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="text-left"><a href="#!" class="semi-bold-txt">Tahlia</a></td>
                        <td>12</td>
                        <td>2</td>
                      </tr>
                      <tr>
                        <td class="text-left"><a href="#!" class="semi-bold-txt">King Abdulaziz</a></td>
                        <td>23</td>
                        <td>3</td>
                      </tr>
                      <tr>
                        <td class="text-left"><a href="#!" class="semi-bold-txt">Gornata</a></td>
                        <td>34</td>
                        <td>4</td>
                      </tr>
                      <tr>
                        <td class="text-left"><a href="#!" class="semi-bold-txt">Tahlia</a></td>
                        <td>12</td>
                        <td>2</td>
                      </tr>
                      <tr>
                        <td class="text-left"><a href="#!" class="semi-bold-txt">Gornata</a></td>
                        <td>34</td>
                        <td>4</td>
                      </tr>
                      <tr>
                        <td class="text-left"><a href="#!" class="semi-bold-txt">King Abdulaziz</a></td>
                        <td>23</td>
                        <td>3</td>
                      </tr>
                      <tr>
                        <td class="text-left"><a href="#!" class="semi-bold-txt">Gornata</a></td>
                        <td>34</td>
                        <td>4</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-lg-9 col-xl-10 col-12 pl-0">
              <div class="bg-white h-100">
                <div class="row">
                  <div class="col-md-9 pl-md-4 pr-md-0 pl-4 pr-4 pb-1 pt-md-0 pt-2">
                    <div class="row select-sec revews-selectbox">
                      <div class="col py-2">
                        <select class="form-control">
                          <option value="" selected="">Sources</option>
                          <option value="Sources # 1">Sources # 1</option>
                          <option value="Sources # 2">Sources # 2</option>
                          <option value="Sources # 3">Sources # 3</option>
                          <option value="Sources # 4">Sources # 4</option>
                        </select>
                      </div>
                      <div class="col py-2">
                        <select class="form-control">
                          <option value="" selected="">Period</option>
                          <option value="Period # 1">Period # 1</option>
                          <option value="Period # 2">Period # 2</option>
                          <option value="Period # 3">Period # 3</option>
                          <option value="Period # 4">Period # 4</option>
                        </select>
                      </div>
                      <div class="col py-2">
                        <select class="form-control">
                          <option value="" selected="">Groups</option>
                          <option value="Groups # 1">Groups # 1</option>
                          <option value="Groups # 2">Groups # 2</option>
                          <option value="Groups # 3">Groups # 3</option>
                          <option value="Groups # 4">Groups # 4</option>
                        </select>
                      </div>
                      <div class="col py-2">
                        <select class="form-control">
                          <option value="" selected="">Locations</option>
                          <option value="Locations # 1">Locations # 1</option>
                          <option value="Locations # 2">Locations # 2</option>
                          <option value="Locations # 3">Locations # 3</option>
                          <option value="Locations # 4">Locations # 4</option>
                        </select>
                      </div>
                      <div class="col py-2">
                        <select class="form-control">
                          <option value="" selected="">Competitor</option>
                          <option value="Competitor # 1">Competitor # 1</option>
                          <option value="Competitor # 2">Competitor # 2</option>
                          <option value="Competitor # 3">Competitor # 3</option>
                          <option value="Competitor # 4">Competitor # 4</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 pr-4 mt-3">
                    <div class="heading-with_icon border-0 text-right">
                      <div class="col_right text-nowrap"> <a href="#!" class="fa fa-reply mr-1" aria-hidden="true"></a> <a href="#!" class="fa fa-times" aria-hidden="true"></a> </div>
                    </div>
                  </div>
                </div>
                <div class="row mr-0">
                  <div class="col-lg-12 col-12 px-10 px-r-0 pr-md-0">
                    <div class="white-rounded-box rounded-0 pt-1 pb-0 border-top">
                      <div class="clearfix"></div>
                      <div class="map_wrap">
                        <div id="performance_trend" style="min-width: 250px; height: 350px; margin: 0 auto"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

@endsection
