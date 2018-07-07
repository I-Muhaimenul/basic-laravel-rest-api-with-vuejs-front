<div class="panel-body">
    @if (session('status'))
        <div class="alert alert-success" style="text-align:center;">
            <h4 class="alert-heading">{{ session('status') }}</h4>
            <hr>
            <p>You're successfully logged in!</p>
        </div>
    @endif
</div>
<p>User Dashboard</p>