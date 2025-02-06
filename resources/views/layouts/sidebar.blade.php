<div class="sidebar-crm" style="height: 870px; position: relative; top: 0px; background: #7f56d9; max-width: 250px;">
    <div class="text-white h-100 rounded-3">
        <ul class="list-unstyled pt-4">
            <li>
                <a href="{{ route('dashboard') }}" class="d-block px-4 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-home me-2"></i> 
                    <span class="sidebar-text"> Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('leads.index') }}" class="d-block px-4 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-file-signature me-3"></i> 
                    <span class="sidebar-text"> Proposal</span>
                </a>
            </li>
            @if(Auth::user()->role == 'user')
            <li>
                <a href="{{ route('connect.index') }}" class="d-block px-4 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-link me-3"></i> 
                    <span class="sidebar-text"> Connects</span> 
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 'admin')
            <li>
                <a href="{{ route('user.connect') }}" class="d-block px-4 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-link me-3"></i> 
                    <span class="sidebar-text"> Connects</span> 
                </a>
            </li>
            @endif
            @if(Auth::user()->role == 'admin')
            <li>
                <a href="{{ route('user.index') }}" class="d-block px-4 py-2 rounded text-white text-decoration-none hover-bg-dark hover-text-primary d-flex align-items-center">
                    <i class="fas fa-user-cog me-3"></i> 
                    <span class="sidebar-text"> Users</span>
                </a>
            </li>
            @endif
        </ul>        
    </div>
</div>
