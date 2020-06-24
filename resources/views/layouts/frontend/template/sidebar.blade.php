<div class="sidebar">
    <div class="scrollbar-inner sidebar-wrapper">
        <div class="user">
            <div class="photo" style="margin-top:-8px">
                <img  src="../assets/img/{{Auth::user()->profile}}"/>
            </div>
            <div class="info">
                <a>
                    <span>
                        {{Auth::user()->first_name}}.{{Auth::user()->last_name}}
                        <span class="user-level"></span>
                    </span>
                </a>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item active" id="1" onclick="focus()">
                <a href="/home">
                    <span class="material-icons text-primary">dashboard</span>
                    <strong style="margin-left: 15px;">Dashboard</strong>
                </a>
            </li>
        </ul>
    </div>
</div>
