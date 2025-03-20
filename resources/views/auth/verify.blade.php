@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
		<div class="container-fluid">
		</div>
    </section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header bg-secondary">
							<h3>{{ __('Verify Your Email Address') }}</h3>
						</div>
						<div class="card-body">
							@if (session('resent'))
								<div class="alert alert-success" role="alert">
									{{ __('A fresh verification link has been sent to your email address.') }}
								</div>
							@endif
							{{ __('Before proceeding, please check your email for a verification link.') }}
							{{ __('If you did not receive the email') }},
						</div>
						<div class="card-footer">
                            <div class="row">
                                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
										@csrf
										<button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('click here to request another') }}</button>
									</form>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
