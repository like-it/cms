{R3M}
<li>
    <div
        class="accordion accordion-flush"
        id="{{$li.id}}"
    >
        <div class="accordion-item">
            <h2
                class="accordion-header"
                id="{{$li.flush.heading.1}}"
            >
                <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#{{$li.flush.collapse.1}}"
                    aria-expanded="false"
                    aria-controls="{{$li.flush.collapse.1}}"
                >
                    {{$li.title}}
                </button>
            </h2>
            <div
                id="{{$li.flush.collapse.1}}"
                class="accordion-collapse collapse"
                aria-labelledby="{{$li.flush.heading.1}}"
                data-bs-parent="#{{$li.id}}"
            >
                <div class="accordion-body">
                    {{sentences($li.description)}}
                </div>
            </div>
        </div>
    </div>
</li>