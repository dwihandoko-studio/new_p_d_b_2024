<div id="DZ_W_TimeLine" class="widget-timeline dlab-scroll height370">
    <ul class="timeline">
        <li>
            <div class="timeline-badge primary"></div>
            <a class="timeline-panel text-muted" href="#">
                <span><?= make_time_long_ago_new($data->created_at) ?></span>
                <h6 class="mb-0"><?= $data->jenis_pengaduan ?> <strong class="text-primary"><?= getStatusTicketPengaduan($data->status) ?></strong>.</h6>
            </a>
        </li>
        <!-- <li>
            <div class="timeline-badge info">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>20 minutes ago</span>
                <h6 class="mb-0">New order placed <strong class="text-info">#XF-2356.</strong></h6>
                <p class="mb-0">Quisque a consequat ante Sit amet magna at volutapt...</p>
            </a>
        </li>
        <li>
            <div class="timeline-badge danger">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>30 minutes ago</span>
                <h6 class="mb-0">john just buy your product <strong class="text-warning">Sell $250</strong></h6>
            </a>
        </li>
        <li>
            <div class="timeline-badge success">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>15 minutes ago</span>
                <h6 class="mb-0">StumbleUpon is acquired by eBay. </h6>
            </a>
        </li>
        <li>
            <div class="timeline-badge warning">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>20 minutes ago</span>
                <h6 class="mb-0">Mashable, a news website and blog, goes live.</h6>
            </a>
        </li>
        <li>
            <div class="timeline-badge dark">
            </div>
            <a class="timeline-panel text-muted" href="#">
                <span>20 minutes ago</span>
                <h6 class="mb-0">Mashable, a news website and blog, goes live.</h6>
            </a>
        </li> -->
    </ul>
</div>