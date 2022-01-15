<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<style>
	.login-form {
		width: 340px;
		margin: 50px auto;
		font-size: 15px;
	}
	
	.login-form form {
		margin-bottom: 15px;
		background: #f7f7f7;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		padding: 30px;
	}
	
	.login-form h2 {
		margin: 0 0 15px;
	}
	
	.form-control,
	.btn {
		min-height: 38px;
		border-radius: 2px;
	}
	
	.btn {
		font-size: 15px;
		font-weight: bold;
	}
	</style>
	<div class="container">
		<div class="row">
			<?php if (validation_errors()) : ?>
				<div class="col-md-12">
					<div class="alert alert-danger" role="alert">
						<?php echo validation_errors() ?>
					</div>
				</div>
				<?php endif; ?>
					<?php if (isset($error)) : ?>
						<div class="col-md-12">
							<div class="alert alert-danger" role="alert">
								<?php echo $error ?>
							</div>
						</div>
						<?php endif; ?>
		</div>
		<div class="login-form">
			<?php echo form_open() ?>
				<h2 class="text-center">SecurePass Log in</h2>
					<div class="form-group">
						<input type="text" class="form-control" id="username" name="username" placeholder="Username" required="required"> </div>
					<div class="form-group">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" required="required"> </div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Log in</button>
					</div>
					<div class="clearfix">
						<a href="<?php echo base_url('index.php/reset_password') ?>" class="float-right">Forgot Password?</a> 
					</div>
				</form>
				<p class="text-center"><a href="<?php echo base_url('index.php/register') ?>">Create an Account</a></p>
		</div>
	</div>
	<!-- .container -->
	</body>

	</html>