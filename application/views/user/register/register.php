<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<div class="container">
		<style>
		.help-block {
			font-size: 0.8rem;
		}
		</style>
		<div class="mask d-flex align-items-center h-100 gradient-custom-3">
		<div class="container h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-9 col-lg-7 col-xl-6">
					<div class="card" style="border-radius: 15px;">
						<div class="card-body p-4">
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
												<div class="col-md-12">
													<div class="page-header">
														<h1>Register</h1> </div>
													<?php echo form_open() ?>
														<div class="form-group">
															<label for="username">Username</label>
															<input type="text" class="form-control" id="username" name="username" placeholder="Enter a username">
															<p class="help-block">At least 4 characters, letters or numbers only</p>
														</div>
														<div class="form-group">
															<label for="email">Email</label>
															<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
															<p class="help-block">A valid email address</p>
														</div>
														<div class="form-group">
															<label for="password">Password</label>
															<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
															<p class="help-block">At least 6 characters</p>
														</div>
														<div class="form-group">
															<label for="password_confirm">Confirm password</label>
															<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password">
															<p class="help-block">Must match your password</p>
														</div>
														<div class="form-group">
															<input type="submit" class="btn btn-default" value="Register"> </div>
														</form>
												</div>
							</div>
							<!-- .row -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- .container -->