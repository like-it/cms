{{R3M}}
{{$field = 'name'}}
<div class="dialog dialog-save-as d-none">
    <div class="head">
        <h1>Save as</h1>
        <span class="close">
            <i class="fas fa-window-close"></i>
        </span>
    </div>
    <div class="body">
        {{html.input([
        'id' => $module + '-' + $submodule + '-' + $field,
        'name' => $field,
        'label' => 'New name',
        'value' => request('node.' + $field),
        'type' => 'text',
        'autocorrect' => 'off',
        'autocapitalize' => 'off',
        'spellcheck' => 'false'
        ])}}
        <input type="checkbox" name="node.class_rename" value="true" checked="checked" />
        <label>Rename class</label>
    </div>
    <div class="footer">
        <div class="w-50 d-inline-block text-center">
            <button type="button" class="btn btn-primary button-submit">
                Ok
            </button>
        </div><div class="w-50 d-inline-block text-center">
            <button type="button" class="btn btn-primary button-cancel">
                Cancel
            </button>
        </div>
    </div>
</div>