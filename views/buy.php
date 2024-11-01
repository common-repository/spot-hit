<?php

/**
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Cyril Bouxin
 * @copyright 2015-2022 NETSIZE
 * @license GNU General Public License version 2
 */

$key = $credits['key'];

$key_length =  strlen($key);
$key_visible = str_split($key, 5);

$key_hidden = $key_visible[0] . '****';

?>


<div class="container-fluid page_title_container mb-3">
    <div class="row">
        <div class="col spothit_header">
            <h1 class="m-0"><?php _e('Buy credits', 'spothit') ?></h1>
        </div>
    </div>
</div>

<div class="container-fluid page_content_container page_automatic_campaign_content_container" id="spothit_container"
    data-url="automating">
    <div class="row">

    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="spothit_content">

                <div class="row purchase-product">
                    <div class="col-md-12 purchase-container">
                        <div class="col-md-12 purchase-container">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="purchase-col purchase-summary">
                                        <div class="purchase-volume">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="line line-product-volume">
                                                                <p class="product-volume"><span
                                                                        class="num d-none d-md-block">1</span>
                                                                    <span><?php _e('Enter', 'spothit'); ?>&nbsp;</span><?php _e('your volume', 'spothit'); ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="line line-product-input">
                                                                <div class="input-group input-group-volume">
                                                                    <input type="text" id="volume-product"
                                                                        placeholder="<?php _e('Volume', 'spothit'); ?>"
                                                                        class="form-control input-large">
                                                                    <div class="input-group-btn-vertical">
                                                                        <button class="btn btn-default" type="button"><i
                                                                                class="fa-light fa-chevron-up"></i></button>
                                                                        <button class="btn btn-default" type="button"><i
                                                                                class="fal fa-chevron-down"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="purchase-col purchase-grid">

                                        <div class="row d-block d-md-none">
                                            <div class="col-md-12">
                                                <div class="line line-product-name">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <p class="product-name"><span>SMS</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-6 text-center text-xs-right">
                                                            <p class="amount">
                                                                <?php _e('from', 'spothit'); ?>
                                                                &nbsp;<span>100</span>&nbsp;<?php _e('to', 'spothit'); ?>&nbsp;<span>10
                                                                    000</span> :</p>
                                                        </div>
                                                        <div class="col-xs-6 text-center text-xs-left">
                                                            <p class="price show-price-premium-0">111</p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xs-6 text-center text-xs-right">
                                                            <p class="amount">
                                                                <?php _e('from', 'spothit'); ?>&nbsp;<span>10
                                                                    000</span>&nbsp;<?php _e('to', 'spothit'); ?>
                                                                &nbsp;<span>100 000</span> :
                                                            </p>
                                                        </div>
                                                        <div class="col-xs-6 text-center text-xs-left">
                                                            <p class="price show-price-premium-1">222</p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xs-6 text-center text-xs-right">
                                                            <p class="amount">
                                                                <?php _e('more than', 'spothit'); ?>&nbsp;<span>100
                                                                    000</span> :</p>
                                                        </div>
                                                        <div class="col-xs-6 text-center text-xs-left">
                                                            <p class="price show-price-premium-2">333</p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="line line-product-name">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <p class="product-name"><span>EMAIL</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-6 text-center text-xs-right">
                                                            <p class="amount show-price-step-0">
                                                                <?php _e('from', 'spothit'); ?>
                                                                &nbsp;<span>100</span>&nbsp;<?php _e('to', 'spothit'); ?>&nbsp;<span>10
                                                                    000</span> :</p>
                                                        </div>
                                                        <div class="col-xs-6 text-center text-xs-left">
                                                            <p class="price show-price-html-0">444</p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xs-6 text-center text-xs-right">
                                                            <p class="amount show-price-step-1">
                                                                <?php _e('from', 'spothit'); ?>&nbsp;<span>10
                                                                    000</span>&nbsp;<?php _e('to', 'spothit'); ?>
                                                                &nbsp;1000<span class="show-price-step-1"></span> :
                                                            </p>
                                                        </div>
                                                        <div class="col-xs-6 text-center text-xs-left">
                                                            <p class="price show-price-html-1">555</p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-xs-6 text-center text-xs-right">
                                                            <p class="amount show-price-step-2">
                                                                <?php _e('more than', 'spothit'); ?>&nbsp;<span>100
                                                                    000</span> :</p>
                                                        </div>
                                                        <div class="col-xs-6 text-center text-xs-left">
                                                            <p class="price show-price-html-2">666</p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="product-pack" style="">
                                                            <div class="line line-product-btn">
                                                                <p class="text-center">
                                                                    <span class="product-final-price product-01-price"
                                                                        id="product-resp-01-price">...</span> <span
                                                                        class="product-currency">€</span><span
                                                                        class="product-taxes">&nbsp;&nbsp;<?php _e('escl. vat.', 'spothit'); ?></span>
                                                                </p>
                                                                <p class="text-center">
                                                                    <a class="btn btn-success btn-large btn-purchase btn-commande"
                                                                        href="#" rel="nofollow"
                                                                        data-type="premium"><?php _e('Add to cart', 'spothit'); ?></a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-none d-md-block">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="line line-product-name">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <p class="purchase-title"><span class="num">2</span>
                                                                    <?php _e('Prices', 'spothit'); ?>
                                                                    <span><?php _e('escl. vat.', 'spothit'); ?></span>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h2 class="product-name"><span>SMS</span></h2>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h2 class="product-name"><span>EMAIL</span></h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="line line-product-price even active" data-palier="0">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="price-step-content">
                                                                    <p class="amount show-price-step-0">
                                                                        <?php _e('from', 'spothit'); ?>&nbsp;<span>100</span>&nbsp;<?php _e('to', 'spothit'); ?>&nbsp;<span>10
                                                                            000</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="price-step-content">
                                                                    <p class="price text-center show-price-premium-0">
                                                                        ...</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="price-step-content">
                                                                    <p class="price text-center show-price-html-0">...
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="line line-product-price odd" data-palier="1">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="price-step-content">
                                                                    <p class="amount show-price-step-1">
                                                                        <?php _e('from', 'spothit'); ?>&nbsp;<span>10
                                                                            000</span>&nbsp;<?php _e('to', 'spothit'); ?>&nbsp;<span>100
                                                                            000</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="price-step-content">
                                                                    <p class="price text-center show-price-premium-1">
                                                                        ...</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="price-step-content price-html-1">
                                                                    <p class="price text-center show-price-html-1">...
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="line line-product-price even" data-palier="2">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="price-step-content">
                                                                    <p class="amount show-price-step-2">
                                                                        <?php _e('more than', 'spothit'); ?>&nbsp;<span>100
                                                                            000</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="price-step-content">
                                                                    <p class="price text-center show-price-premium-2">
                                                                        ...</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="price-step-content">
                                                                    <p class="price text-center show-price-html-2">...
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none d-md-block mt-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="line line-product-btn">
                                                        <p class="purchase-title"><span class="num">3</span> Total</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="product-pack">
                                                        <div class="line line-product-btn">
                                                            <p class="text-center">
                                                                <span class="product-final-price product-01-price"
                                                                    id="product-01-price">...</span> <span
                                                                    class="product-currency">€</span><span
                                                                    class="product-taxes">&nbsp;&nbsp;<?php _e('escl. vat.', 'spothit'); ?></span>
                                                            </p>
                                                            <p class="text-center">
                                                                <a class="btn btn-success btn-large btn-purchase btn-commande"
                                                                    target="_blank" id="purchase_html"
                                                                    href="https://www.spot-hit.fr/espace-client/commandes/ajouter?product=premium&quantity=100"
                                                                    rel="nofollow"
                                                                    data-type="premium"><?php _e('Add to cart', 'spothit'); ?></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="product-pack">
                                                        <div class="line line-product-btn">
                                                            <p class="text-center">
                                                                <span class="product-final-price product-02-price"
                                                                    id="product-02-price">...</span> <span
                                                                    class="product-currency">€</span><span
                                                                    class="product-taxes">&nbsp;&nbsp;<?php _e('escl. vat.', 'spothit'); ?></span>
                                                            </p>
                                                            <p class="text-center">
                                                                <a class="btn btn-success btn-large btn-purchase btn-commande"
                                                                    target="_blank" id="purchase_premium"
                                                                    href="https://www.spot-hit.fr/espace-client/commandes/ajouter?product=html&quantity=100"
                                                                    rel="nofollow"
                                                                    data-type="html"><?php _e('Add to cart', 'spothit'); ?></a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>