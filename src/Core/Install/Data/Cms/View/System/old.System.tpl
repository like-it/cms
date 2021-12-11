<section name="system">
    <div class="card-body h-100">
        <h5 class="card-title">{__('update.card.title')}</h5>
        <p class="text-start">
            {implode('<br>', __('update.card.body'))}
        </p>
        /*
        <a  class="btn btn-primary"
            data-url="{server.url('core')}System/Update/Os/"
            data-method="replace"
            data-target="section[name='system'] .system-console"
        >
            {__('update.os.packages')}
        </a>
        */
        <a
            class="btn btn-primary"
            data-url="{server.url('core')}System/Update/Cms/"
            data-method="replace"
            data-target="section[name='system'] .system-console"
        >
            {__('update.cms.packages')}
        </a>
        <br><br>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a
                                class="nav-link active"
                                aria-current="true"
                            >
                                Console
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body system-console h-100 text-start">
                </div>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</section>