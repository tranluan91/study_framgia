{# ==== include CSS =====#}
<?php
    $config = $this->di->get('config');
    $url = $config->url;
?>
{% block css %}
    {{ stylesheet_link('css/bootstrap/dist/css/bootstrap.min.css') }}
    {{ stylesheet_link('css/bootstrap.no-responsive.css') }}
    {{ stylesheet_link('css/style.css') }}
{% endblock %}

<div class="navbar custom-navbar navbar-fixed-top navbar-right" role="navigation">
    <div class="container">
        <div class="navbar-header">
            {{ link_to('index', 'Index', 'class': 'navbar-brand', 'id': 'navbar-header-text') }}
        </div>
        <div class="navbar-right">
            {{ link_to('index/cart', 'Cart(' ~ cartItemCount ~ ')', 'class': 'navbar-brand', 'id':'navbar-header-right') }}
        </div>
    </div>
</div>