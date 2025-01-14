<div class="container" style="width: 278px; height: 870px; position: relative; top: 0px; background: #7f56d9;">
    <div class="text-white h-100 rounded-3">
        <ul class="list-unstyled p-4">
            <li>
                <a href="{{ route('dashboard') }}" class="d-block px-4 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-tachometer-alt me-2"></i> 
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('leads.index') }}" class="d-block px-4 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-users me-3"></i> 
                    Proposal
                </a>
            </li>
            <li>
                <a href="{{ route('connect') }}" class="d-block px-4 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-users me-3"></i> 
                    Connects
                </a>
            </li>
            @if(Auth::user()->role == 'admin')
            <li>
                <a href="{{ route('user.index') }}" class="d-block px-4 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-users me-3"></i> 
                    Users
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>
