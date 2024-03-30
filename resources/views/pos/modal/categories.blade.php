<div class="modal fade product_categories_modal" id="product_categories_modal" tabindex="-1" role="dialog"
     aria-labelledby="product_categories_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Categories</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"> </i>
                </button>
            </div>
            <div class="modal-body">
                <div data-scroll="true" data-height="620">
                    <ul class="navi navi-link-rounded navi-accent navi-hover flex-column mb-8 mb-lg-0"
                        role="tablist">
                        @foreach (\App\Providers\FormList::getProductCategories() as $product_category)
                            <li class="navi-item border-bottom" style="border-bottom: 1px">
                                <a href="javascript:void(0);"
                                   class="navi-link item_category_selection active"
                                   data-category-id="{{ $product_category->id }}">
                                    <span class="navi-text text-dark-50">
                                        {{ $product_category->name }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
