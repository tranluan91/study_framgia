{{ partial("layouts/index") }}

<div id="content">
    <div class="container">
<a href="<?= $this->facebook->getLoginUrl(['scope' => $this->config->facebook->scope, 'redirect_uri' => $url .$this->url->get('user/facebook')]) ?>"><span class="fa"></span>Facebook Login
</a>
        <h1>Products</h1>
        {% if action is defined and action === "add" %}
            <div class="alert alert-warning"> {{ name }} was added to your cart</div>
        {% elseif action is defined and action === "exists" %}
            <div class="alert alert-warning"> {{ name }} already exists in your cart </div>
        {% endif %}

        <table class="table">
            <tr>
                <th>Product name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            {% for product in products %}
            <tr>
                <td>{{ product.name }}</td>
                <td>{{ product.price }}</td>
                <td>{{ link_to("index/cartadd?id=" ~ product.id ~ "&name=" ~ product.name,"Add", "class":"customButton",
                                  "title":"Add to Cart") }}
                </td>
            </tr>
            {% endfor %}
        </table>
    </div>
</div>
