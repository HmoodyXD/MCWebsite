{include file='header.tpl'}

<body id="page-top">

    <!-- Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        {include file='sidebar.tpl'}

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main content -->
            <div id="content">

                <!-- Topbar -->
                {include file='navbar.tpl'}

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">{$USERS}</h1>
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{$PANEL_INDEX}">{$DASHBOARD}</a></li>
                            <li class="breadcrumb-item active">{$USER_MANAGEMENT}</li>
                            <li class="breadcrumb-item active">{$USERS}</li>
                        </ol>
                    </div>

                    <!-- Update Notification -->
                    {include file='includes/update.tpl'}

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <h5 style="margin-top: 7px; margin-bottom: 7px;">{$VIEWING_USER_SESSIONS}</h5>
                                </div>
                                <div class="col-md-3">
                                    <span class="float-md-right">
                                        <a href="{$BACK_LINK}" class="btn btn-warning">{$BACK}</a>
                                    </span>
                                </div>
                            </div>
                            <hr />

                            <!-- Success and Error Alerts -->
                            {include file='includes/alerts.tpl'}

                            <div class="table-responsive">
                                <table class="table table-borderless table-striped">
                                    <thead>
                                        <tr>
                                            <th>{$DEVICE}</th>
                                            <th>{$IP_ADDRESS}</th>
                                            <th>{$LAST_SEEN}</th>
                                            <th>{$ACTIVE}</th>
                                            <th>{$LOGIN_METHOD}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {foreach $SESSIONS as $session}
                                            <tr>
                                                <td>
                                                    {$session.device}
                                                </td>
                                                <td>
                                                    {$session.ip}
                                                </td>
                                                <td>
                                                    <span data-toggle="tooltip" data-title="{$session.last_seen_long}">{$session.last_seen_short}</span>
                                                </td>
                                                <td>
                                                    {if $session.active}
                                                        <i class="fa fa-check-circle text-success"></i>
                                                    {else}
                                                        <i class="fa fa-times-circle text-danger"></i>
                                                    {/if}
                                                </td>
                                                <td>
                                                    {$session.method|ucfirst}
                                                </td>
                                                <td class="text-right">
                                                    {if $session.active}
                                                        <form action="" method="post">
                                                            <input type="hidden" name="action" value="logout">
                                                            <input type="hidden" name="token" value="{$TOKEN}">
                                                            <input type="hidden" name="sid" value="{$session.id}">
                                                            <button type="submit" class="btn btn-danger btn-sm">{$LOGOUT}</button>
                                                        </form>
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/foreach}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {include file='footer.tpl'}
        </div>
    </div>

    {include file='scripts.tpl'}
</body>