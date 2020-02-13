<% include Banner %>
<!-- BEGIN CONTENT -->
<div class="content">
	<div class="container">
		<div class="row">
			<div class="main col-sm-8">
				$Content

				<%-- This will render out the login or register forms  --%>
				$Form
			</div>

			<div class="sidebar gray col-sm-4">
				<% if $Menu(2) %>
					<h3>In this Section</h3>
					<ul class="subnav">
						<% loop $Menu(2) %>
							<li><a class="$LinkingMode" href="$Link">$MenuTitle</a></li>
						<% end_loop %>
					</ul>
				<% end_if %>
				<%-- <h2 class="section-title">In this section</h2>
				<ul class="categories subnav">
					<li><a href="#">Company</a></li>
					<li><a href="#">FAQ</a></li>
					<li><a href="#">Careers</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Terms of Use</a></li>
					<li><a href="#">Privacy Policy</a></li>
				</ul> --%>
			</div>
		</div>
	</div>
</div>
<!-- END CONTENT -->
