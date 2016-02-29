<div class="row">
	<div class="medium-5 medium-centered large-5 columns large-centered logbox">	
		<div class="medium-7 medium-centered large-7 columns large-centered text-center">
			<img class="img-responsive" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
		</div>
		<div class="medium-10 medium-centered large-10 columns large-centered text-center">
			<h4>Office Management App</h4>
		</div>
		<?php echo form_open('login/verification'); ?>
			<?php
			if( isset($param_get) ){
				echo '
					<div data-alert class="alert-box alert radius">
						Invalid login
						<a href="#" class="close">&times;</a>
					</div>
				';
			}
			?>
			<div class="medium-12 medium-centered large-12 columns large-centered text-center" style="margin-top: 9%;">
				<input type="text" name="username" placeholder="Username" />
			</div>
			<div class="medium-12 medium-centered large-12 columns large-centered text-center" style="margin-top: 9%;">
				<input type="password" name="password" placeholder="Password" />
			</div>
			<div class="medium-12 medium-centered large-12 columns large-centered text-center" style="margin-top: 9%;">				
				<button type="submit" class="button expand">Log In</button>
			</div>
		</form>
	</div>
</div>