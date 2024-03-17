@if(!empty($item_categories['result']->toArray()))
<ul class="navi navi-link-rounded navi-accent navi-hover flex-column mb-8 mb-lg-0" role="tablist">
    @foreach ($item_categories['result'] as $key => $category)
    @php $category_name = ($local_value == 'ar') ? ($category->a_name == null) ? $category->name : $category->a_name : ucwords(strtolower($category->name)); @endphp
        <li class="navi-item border-bottom" style="border-bottom: 1px">
            <a href="javascript:void(0);"
               class="navi-link item_category_selection active"
               data-category-id="{{ $category->id }}">
                <span class="navi-text text-dark-50 font-weight-bold h6">
                    {{ $category_name }}
                </span>
            </a>
        </li>
    @endforeach
</ul>
@endif
