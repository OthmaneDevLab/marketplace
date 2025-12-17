<h1>Vendor Dashboard</h1>

<p>Status: {{ auth()->user()->vendor->status }}</p>

@if(auth()->user()->vendor->status !== 'approved')
    <p>Your account is under review.</p>
@endif
