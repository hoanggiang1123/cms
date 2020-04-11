<tr>
    <th class="text-center pr-0">
        <label>
            <input type="checkbox" class="cball align-bottom" autocomplete="off">
        </label>
    </th>
    @foreach($fields as $filed)
        <th class="d-none d-sm-table-cell">{{ $filed }}</th>
    @endforeach
</tr>