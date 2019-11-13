<template>
	<aside class="left-sidebar" data-sidebarbg="skin5"> 
		<!-- Sidebar scroll-->
		<div class="scroll-sidebar"> 
			<!-- Sidebar navigation-->
			<nav class="sidebar-nav">
				<ul id="sidebarnav" class="pt-0">
					<li class="sidebar-item slider-item-p-l mr-0">
						<a class="d-block" href="/">
							<span class="logo-text w-100 d-inline-block">
								<img src="/assets/images/large-logo.jpg" alt="homepage" class="img-fluid align-top w-100 logo-big" />
								<img src="/assets/images/logo-small.png" alt="homepage" class="img-fluid align-top w-100 logo-small" />
							</span>
						</a>
					</li>

					<li class="sidebar-item slider-item-p-l search-left-nav">
						<input type="search" class="form-control" placeholder="Search.." name="">
					</li>

					<li class="sidebar-item slider-item-p-l">
						<a class="sidebar-link waves-effect waves-dark" href="/" aria-expanded="false">
							<i class="fa fa-home"></i>
							<span class="hide-menu">Home test</span>
						</a>
					</li>

					<li class="sidebar-item slider-item-p-l">
						<!--class for arrows has-arrow -->
						<a onclick="location.href='#';" class="sidebar-link waves-effect waves-dark" aria-expanded="false" id="menu-listings">
							<i class="fa fa-file-text-o"></i>
							<span class="hide-menu">Listings </span>
						</a>
						<ul aria-expanded="false" class="collapse first-level" id="menu-listings-list">
							<li class="sidebar-item">
								<a href="/manage-locations" class="sidebar-link submenu-link" :class="{active: link == 'manage-locations'}">Manage location(s)</a>
							</li>
							<li class="sidebar-item"></li>
							<li class="sidebar-item">
								<a href="/scan" class="sidebar-link submenu-link">Verify Listing(s)</a>
								<!-- <a href="javascript:void(0)" class="sidebar-link has-arrow waves-effect waves-dark">Verify Listing(s)</a>
								<ul aria-expanded="false" class="collapse second-level">
									<li class="sidebar-item">
										<a href="/scan-one" class="sidebar-link submenu-link">Scan one</a>
									</li>
									<li class="sidebar-item">
										<a href="#" class="sidebar-link submenu-link">Scan many</a>
									</li>
								</ul> -->
							</li>
							<li class="sidebar-item">
								<a href="/add-location" class="sidebar-link submenu-link" :class="{active: link == 'add-location'}">Add Location</a>
								<!-- <a href="javascript:void(0)" class="sidebar-link has-arrow waves-effect waves-dark">Add Location</a>
								<ul aria-expanded="false" class="collapse second-level">
									<li class="sidebar-item">
										<a href="/add-location" class="sidebar-link submenu-link">Add one</a>
									</li>
									<li class="sidebar-item">
										<a href="#" class="sidebar-link submenu-link" data-toggle="modal" data-target="#AddMany">Add many</a>
									</li>
								</ul> -->
							</li>
							<li class="sidebar-item">
								<a href="/location-analytics" class="sidebar-link submenu-link" :class="{active: link == 'location-analytics'}">Analytics</a>
							</li>
						</ul>
					</li>
					<li class="sidebar-item slider-item-p-l">
						<!--class for arrows "has-arrow " -->
						<a onclick="location.href='#';" class="sidebar-link waves-effect waves-dark" aria-expanded="false" id="menu-reviews">
							<i class="fa fa-comments-o"></i>
							<span class="hide-menu">Reviews </span>
						</a>
						<ul aria-expanded="false" class="collapse first-level" id="menu-reviews-list">
							<li class="sidebar-item">
								<a href="/manage-reviews" class="sidebar-link submenu-link" :class="{active: link == 'manage-reviews'}">
									<span class="hide-menu"> Manage Reviews </span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="/generate-reviews" class="sidebar-link submenu-link" :class="{active: link == 'generate-reviews'}">
									<span class="hide-menu"> Generate Reviews </span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="/promote-reviews" class="sidebar-link submenu-link" :class="{active: link == 'promote-reviews'}">
									<span class="hide-menu"> Promote Reviews </span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="/smart-response" class="sidebar-link submenu-link" :class="{active: link == 'smart-response'}">
									<span class="hide-menu"> Smart Response</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="/analytics-reviews" class="sidebar-link submenu-link" :class="{active: link == 'analytics-reviews'}">Analytics</a>
							</li>
						</ul>
					</li>
					<li class="sidebar-item slider-item-p-l">
						<!--class for arrows "has-arrow " -->
						<a onclick="location.href='#';" class="sidebar-link waves-effect waves-dark" aria-expanded="false" id="menu-posts">
							<i class="fa fa-pencil-square-o"></i>
							<span class="hide-menu">Posts </span>
						</a>
						<ul aria-expanded="false" class="collapse first-level" id="menu-posts-list">
							<li class="sidebar-item">
								<a href="/create-post" class="sidebar-link submenu-link" :class="{active: link == 'manage-reviews'}">
									<span class="hide-menu">Create Posts</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="/manage-posts" class="sidebar-link submenu-link" :class="{active: link == 'manage-posts'}">
									<span class="hide-menu"> Manage Posts </span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="/schedule-post" class="sidebar-link submenu-link">
									<span class="hide-menu"> Schedule Post </span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="schedule-post-bulk-upload" class="sidebar-link submenu-link">
									<span class="hide-menu"> Bulk Import </span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="#" class="sidebar-link submenu-link">Analytics</a>
							</li>
						</ul>
					</li>
					<li class="sidebar-item slider-item-p-l">
						<!--class for arrows "has-arrow " -->
						<a class="sidebar-link waves-effect waves-dark" onclick="location.href='#';" aria-expanded="false" id="menu-intelligence">
							<i class="fa fa-bullhorn"></i>
							<span class="hide-menu">Intelligence </span>
						</a>
						<ul aria-expanded="false" class="collapse first-level" id="menu-intelligence-list">
							<li class="sidebar-item">
								<a href="#" class="sidebar-link submenu-link">
									<span class="hide-menu"> Consumer Insights </span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="#" class="sidebar-link submenu-link">
									<span class="hide-menu"> Competitive Analysis </span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="#" class="sidebar-link submenu-link">
									<span class="hide-menu"> The Competition </span>
								</a>
							</li>

						</ul>
					</li>
					<li class="sidebar-item slider-item-p-l"> 
						<!--class for arrows "has-arrow " -->
						<a onclick="location.href='#';" class="sidebar-link waves-effect waves-dark" aria-expanded="false" id="menu-settings">
							<i class="fa fa-cogs"></i>
							<span class="hide-menu">Settings </span>
						</a>
						<ul aria-expanded="false" class="collapse first-level" id="menu-settings-list">
							<li class="sidebar-item">
								<a href="/profile" class="sidebar-link submenu-link">
									<span class="hide-menu"> My Profile</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="#" class="sidebar-link submenu-link">
									<span class="hide-menu"> Alert &amp; Notifications</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="/integrations" class="sidebar-link submenu-link" :class="{active: link == 'integrations'}">
									<span class="hide-menu"> Integrations</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="javascript:void(0)" class="sidebar-link submenu-link">
									<span class="hide-menu"> My Subscription </span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="javascript:void(0)" class="sidebar-link submenu-link">
									<span class="hide-menu"> Payment</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a href="/source" class="sidebar-link submenu-link" :class="{active: link == 'source'}">
									<span class="hide-menu"> Source</span>
								</a>
							</li>
						</ul>
					</li>


				</ul>
			</nav>
			<!-- End Sidebar navigation --> 
		</div>
		<!-- End Sidebar scroll-->  
	</aside>
</template>
<script>
	export default {
		name: 'TheSidebar',

		props: ['category', 'link'],

		data() {
			return {

			}
		},
		
		mounted() {
			if(this.category) {
				$(`#menu-${this.category}`).addClass('active')
				$(`#menu-${this.category}-list`).addClass('in')
			}
		}
	}
</script>
