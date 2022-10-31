@extends('layouts.auth')
@push('css')
<meta name="_token" id="token" value="{{csrf_token()}}">
@endpush
@section('content')
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12" id="logins">
					<div class="card-body">
                    	<h4 class="mb-3 f-w-400">Signin</h4>
						<img src="{{asset('assets/images/inventory.png')}}" alt="" class="img-fluid mb-4">
						<form @submit.prevent="login">
						{{-- <div class="form-group fill mb-3">
							<label class="floating-label" for="Email">Email address</label>
							<input type="text" v-model="email" id="Email" class="form-control" :class="msg.email ? 'is-invalid':''" placeholder="">
							<span class="error jquery-validation-error small form-text" :class="msg.email ? 'invalid-feedback':''" role="alert">
								<strong>@{{ msg.email }}</strong>
							</span>

						</div> --}}
                        <div class="form-group fill mb-3">
							<label class="floating-label" for="Username">Username</label>
							<input type="text" v-model="username" id="Username" class="form-control" :class="msg.username ? 'is-invalid':''" placeholder="">
							<span class="error jquery-validation-error small form-text" :class="msg.username ? 'invalid-feedback':''" role="alert">
								<strong>@{{ msg.username }}</strong>
							</span>

						</div>
						<div class="form-group fill mb-4">
							<label class="floating-label" for="Password">Password</label>
							<input type="password" v-model="password" class="form-control" :class="msg.password ? 'is-invalid':''" id="Password" placeholder="">
							<span class="error jquery-validation-error small form-text" :class="msg.password ? 'invalid-feedback':''" role="alert">
								<strong>@{{ msg.password }}</strong>
							</span>
						</div>
						<div class="custom-control custom-checkbox text-left mb-4 mt-2">
							<input type="checkbox" class="custom-control-input" id="customCheck1">
							<label class="custom-control-label" for="customCheck1">Save credentials.</label>
						</div>
                        <button v-if="loading" class="btn btn-sm btn-block btn-primary mb-4"
                                                type="button" disabled>
                                                <div class="spinner-border text-info" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </button>
						<button v-else class="btn btn-block btn-primary mb-4" @click="login">Signin</button>
						<!-- <p class="mb-2 text-muted">Forgot password? <a href="#" class="f-w-400">Reset</a></p> -->
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('js')
@include('components.vuejs')
<script>
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
    var logins = new Vue({
        el:"#logins",
        data:{
            // email:'',
            username:'',
            password:'',
            loading:false,
			msg:[]
        },
        watch: {
            // email(value){
            //     this.email = value;
            //     this.validateEmail(value);
            // },
            username(value){
                this.username = value;
                this.validateUsername(value);
            },
			password(value){
                this.password = value;
                this.validatePassword(value);
            },
		},
        methods:{
            // validateEmail(value){
            //     if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)){
            //         this.msg['email'] = '';
            //     } else{
            //         this.msg['email'] = 'Invalid Email Address';
            //     } 
            // },
			validateUsername(value){
                let difference = 5 - value.length;
                if (value.length < 5){
                    this.msg['username'] = 'Username Must be 5 characters';
                } else{
                    this.msg['username'] = '';
                } 
            },
			validatePassword(value){
                let difference = 6 - value.length;
                if (value.length < 6){
                    this.msg['password'] = 'Must be 6 characters! '+ difference + ' characters left' ;
                } else{
                    this.msg['password'] = '';
                } 
            },
            login(){
                this.loading = true
				const url = "<?php echo route('login');?>";
                const request = {
                    // email:this.email,
                    username:this.username,
                    password:this.password,
                };
                this.$http.post(url,request).then(function(response) {
                    this.loading = false
                    if (response.data.code === 400) {
                        this.msg = response.data.error
                    }else if(response.data.code === 200){
                        location.replace("{{route('home')}}")
                    }
                });
            },
        }
    });
</script>
<script src="{{asset('assets/js/plugins/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/js/pages/form-validation.js')}}"></script>
@endpush