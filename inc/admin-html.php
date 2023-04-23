<div class="wrap">
	<h1>Country Blocker for AdSense</h1>
	<!-- Contenedor de los tabs -->
	<div class="tabcontainer">
		<!-- Botones de los tabs -->
		<button class="tab active" onclick="openTab(event, 'general')">General</button>
		<button class="tab" onclick="openTab(event, 'instructions')">Instructions</button>
		<!-- Contenido de los tabs -->
		<div id="general" class="tabcontent" style="display: block;">
			<form id="cbfa" autocomplete="off" method="POST">
				<input type="hidden" name="action" value="CBFA_guardar_cbfa">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for="trid">Enter your Publisher ID</label>
								<div class="help">
									<span class="help-text">?</span>
									<div class="tooltip tt-bg">
										<p>Find your Publisher ID</p>
										<p>
											1.- Sign in to your AdSense account.<br>
											2.- Click Account. <br>
											3.- In the "Account information" section, see the "Publisher ID" field. <br>
										</p>
									</div>
								</div>
							</th>
							<td>
								<input name="trid" id="trid" type="text" class="regular-text" placeholder="pub-1234567890123456" value="<?php echo esc_html( $settings['id'] ); ?>" required>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="toe">Country to block</label>
								<div class="help">
									<span class="help-text">?</span>
									<div class="tooltip tt-md">
										<p>Add the country code to block.</p>
									</div>
								</div>
							</th>
							<td>
								<input name="toe" id="toe" type="text" class="regular-text" value="<?php echo esc_html( $settings['pais'] ); ?>" placeholder="US,ES,MX..." required>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="apikeyfor">API KEY</label>
								<div class="help">
									<span class="help-text">?</span>
									<div class="tooltip tt-md">
										<p>In order to use this plugin for your own use, you need to create an account on ipgeolocation.io and set your own API Key.</p>
									</div>
								</div>
							</th>
							<td>
								<input name="apikeyfor" id="apikeyfor" type="text" min="1" class="regular-text" value="<?php echo esc_html( $settings['api_key'] ); ?>" placeholder="Your API KEY here" required>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit">
					<input type="submit" name="send" id="send" value="Save settings" class="button button-primary">
				</p>
			</form>
			</div> <!-- cierre del tab container -->
			<div id="instructions" class="tabcontent">
				<h2>Instructions<h2>
				<h3>Find your Publisher ID</h3>
				<h4>In your AdSense account</h4>
				<ol>
				  <li ><a href="http://www.google.com/adsense">Sign in</a> to your AdSense account.</li>
				  <li >Click Account > Settings</li>
				  <li >In the "Account information" section, see the "Publisher ID" field.</li>
				</ol>
				<h4>On Your AdSense page in the AdSense Help Center</h4>
				<ol>
				  <li >Visit the <a href="https://support.google.com/adsense/answer/10568458">Your AdSense page</a> in the AdSense Help Center.</li>
				  <li >If you're not already signed in, sign in to the Google Account you use to access AdSense.</li>
				  <li >Find your publisher ID in the "This email is associated to the AdSense account" field.</li>
				</ol>
				<h3>Adding a country to block</h3>
				<p>To add countries to block, please use the two-letter country code format [<a href="https://laendercode.net/en/2-letter-list.html">more information</a>]. You can add as many countries as you want, but separate each country code with a comma and no spaces in between.&nbsp;</p>
				<p>For example, US,MX,CA</p>
				<p>Or only one country: RU</p>
				<h3>API KEY</h3>
				<p>To use this plugin, you need to create an account on ipgeolocation.io and set up your own API Key. <strong>This is an external service and is not managed by the plugin.</strong></p>
				<h4>How to create your account</h4>
				<ol>
				  <li >Go to ipgeolocation.io</li>
				  <li >Click on &ldquo;Sign up&rdquo;</li>
				  <li >Create your account using your Github, Google account or your own email.</li>
				  <li >Copy your "API Keys" from the ipgeolocation.io dashboard and paste them into the plugin settings.</li>
				</ol>
				<hr>
				<strong>To ensure proper functionality of this plugin, it is necessary for you to remove all AdSense codes beforehand. If you have manually inserted any codes, unfortunately, this plugin does not currently support blocking countries for those codes. Additionally, this plugin is not compatible with any other AdSense plugins such as Ad Inserter or SiteKit.</strong>
				<strong>This plugin is only compatible with AdSense Auto-Ads and cannot be used with any other AdSense plugin.</strong>
  			</div>
		</div>
		<div id="respuesta">
			<div class="notice is-dismissible" style="display:none;"></div>
		</div>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
	    function showNotice(comprobacion) {
	        if (comprobacion) {
	            $(".notice").removeClass('notice-error').addClass("notice-success").html('<p>Saved Settings</p><button type="button" class="notice-dismiss"></button>').show();
	        } else {
	            $(".notice").removeClass('notice-success').addClass("notice-error").html('<p>Error</p><button type="button" class="notice-dismiss"></button>').show();
	        }
	    }
	    // Tooltip
	    $(".help-text").on("mouseover", function() {
	        $(this).next().toggle();
	    }).on("mouseout", function() {
	        $(this).next().hide();
	    }).on("click", function() {
	        $(this).next().toggle();
	    });
	    $("#cbfa").on("submit", function(e) {
	        e.preventDefault();
	        $("#send").prop('disabled', true);
	        var datos = $(this).serialize();
	        $.post(ajaxurl, datos, function(response) {
	            var isTrueSet = (response == 'true');
	            showNotice(isTrueSet);
	            $("#send").prop('disabled', false);
	        });
	    });
	    $(document.body).on("click", ".notice-dismiss", function(e) {
	        $(".notice").hide();
	    });
	});

	function openTab(evt, tabName) {
	    var i, tabcontent, tablinks;
	    // Obtener todos los elementos con clase "tabcontent" y ocultarlos
	    tabcontent = document.querySelectorAll(".tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }
	    // Obtener todos los elementos con clase "tab" y remover la clase "active"
	    tablinks = document.querySelectorAll(".tab");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }
	    // Mostrar el contenido del tab actual y agregar la clase "active" al botón
	    document.getElementById(tabName).style.display = "block";
	    evt.currentTarget.className += " active";
	}
	</script>
	<style type="text/css">
	.help {
		display: inline-block;
		margin-left: 5px;
	}
	.help-text {
		color: #000;
		border: 1px solid #000;
		width: 17px;
		line-height: 17px;
		text-align: center;
		height: 17px;
		display: block;
		cursor: pointer;
		border-radius: 100%;
	}
	.tooltip {
		display: none;
		position: absolute;
		background: #000;
		color: #EEE;
		padding: 10px;
		border-radius: 5px;
		margin: -30px 0px 0px 40px;
	}
	.tooltip:before {
		content: '';
		width: 20px;
		height: 20px;
		background: #000;
		margin-left: -20px;
		margin-top: 0%;
		transform: rotate(45deg);
		display: block;
		float: left;
		z-index: 9998;
	}
	.help * {
	user-select: none;
	}
	.tt-xb {
		width: 500px;
	}
	.tt-bg {
		width: 400px;
	}
	.tt-md {
		width: 300px;
	}
	.tt-sm {
		width: 200px;
	}
	.tt-xs {
		width: 100px;
	}
	/* Estilos para el contenido de los tabs */
	.tabcontent {
		display: none;
		padding: 6px 12px;
		border: 1px solid #ccc;
		border-top: none;
	}
	/* Estilos para los botones de los tabs */
	.tab {
		display: inline-block;
		margin: 0;
		padding: 6px 12px;
		border: 1px solid #ccc;
		border-top-left-radius: 4px;
		border-top-right-radius: 4px;
		background-color: #f1f1f1;
		cursor: pointer;
	}
	/* Estilos para el botón activo del tab */
	.active {
		background-color: #fff;
		border-color: #ccc;
		border-bottom: none;
	}
	</style>
