<template>
	<header class="topbar" data-navbarbg="skin5">
		<nav class="navbar top-navbar navbar-expand-md navbar-dark">
			<div class="navbar-header" data-logobg="skin5"> 
				<!-- This is for the sidebar toggle which is visible on mobile only --> 
				<a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a> 
				<!-- Toggle which is visible on mobile only --> 
				<a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-ellipsis-h font-22"></i></a>
			</div>

			<!-- End Logo -->
			<div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5"> 
				<!-- toggle and nav items -->
				<ul class="navbar-nav float-left mr-auto">
					<li class="nav-item d-none d-md-block">
						<a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar">
							<i class="fa fa-bars font-18"></i>
						</a>
					</li>
				</ul>

				<!-- Right side toggle and nav items -->
				<ul class="navbar-nav float-right">
					<li class="nav-item dropdown">
						<a class="nav-link waves-effect waves-dark" href="#">
							<i class="fa fa-cogs font-18 po-t-1" aria-hidden="true"></i>
						</a>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="fa-stack fa-2x has-badge has-badge-stack notification" data-count="10">
								<i class="fa fa-bell-o font-18"></i>
							</span>
						</a>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span class="fa-stack fa-2x has-badge has-badge-stack" data-count="2">
								<i class="fa fa-flag-o font-18"></i>
							</span>
						</a>
					</li>

					<!-- User profile and search -->
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="/assets/images/user-pic.png" alt="user" class="rounded-circle" width="34">
							{{ user.first_name }} {{ user.last_name }}
						</a>
						<div class="dropdown-menu dropdown-menu-right user-dd animated">
							<a class="dropdown-item" href="/profile">
								<i class="fa fa-user-o m-r-5 m-l-5"></i>
								My Profile
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="javascript:void(0)">
								<i class="fa fa-cog m-r-5 m-l-5"></i>
								Account Setting
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="/logout">
								<i class="fa fa-power-off m-r-5 m-l-5"></i>
								Logout
							</a>
						</div>
					</li>

				</ul>
			</div>
		</nav>
	</header>
</template>
<script>
	export default {
		name: 'TheHeader',

		props: ['user'],

		data() {
			return {

			}
		},

		computed: {

		},

		mounted() {

		},

		methods: {

		},

		created() {

		}

	}
</script>