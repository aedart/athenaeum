import{_ as o,M as p,p as i,q as l,R as n,N as t,U as e,t as s,a1 as c}from"./framework-efe98465.js";const r={},u=n("h1",{id:"payload-format",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#payload-format","aria-hidden":"true"},"#"),s(" Payload Format")],-1),d=n("p",null,[s("You can set a request's payload format, by using one the the following methods. Details on how to set the payload, is covered in the upcoming "),n("a",{href:"./data"},"section"),s(".")],-1),k={class:"table-of-contents"},m=c(`<h2 id="json" tabindex="-1"><a class="header-anchor" href="#json" aria-hidden="true">#</a> Json</h2><p>If you are sending Json, then you can use the <code>jsonFormat()</code> method to ensure that all of your request&#39;s payload (request body) is automatically Json encoded. The method will also automatically set the <code>Accept</code> and <code>Content-Type</code> headers to <code>application/json</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">jsonFormat</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">post</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Alicia&#39;</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;job&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Painter&#39;</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="form" tabindex="-1"><a class="header-anchor" href="#form" aria-hidden="true">#</a> Form</h2><p>To send form data (<em><code>Content-Type: application/x-www-form-urlencoded</code></em>), use the <code>formFormat()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">formFormat</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">post</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/subscribe&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;email&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;jim@acme.org&#39;</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="multipart" tabindex="-1"><a class="header-anchor" href="#multipart" aria-hidden="true">#</a> Multipart</h2><p>When you need to send files as part of your request, use <code>multipartFormat()</code>. It will set the <code>Content-Type</code> to <code>multipart/form-data</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">multipartFormat</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">attachFile</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;profile_picture&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;/img/profile.png&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">post</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/profile-picture&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>You can find more information about sending files, in the <a href="./attachments">attachments section</a>.</p><h2 id="via-configuration" tabindex="-1"><a class="header-anchor" href="#via-configuration" aria-hidden="true">#</a> Via Configuration</h2><p>The data format can also be specified in your http client&#39;s profile options, in your configuration.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>DefaultHttpClient</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                <span class="token string single-quoted-string">&#39;data_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>GuzzleHttp<span class="token punctuation">\\</span>RequestOptions</span><span class="token operator">::</span><span class="token constant">JSON</span><span class="token punctuation">,</span>

                <span class="token comment">// ... remaining not shown ...</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,13);function g(v,h){const a=p("router-link");return i(),l("div",null,[u,d,n("nav",k,[n("ul",null,[n("li",null,[t(a,{to:"#json"},{default:e(()=>[s("Json")]),_:1})]),n("li",null,[t(a,{to:"#form"},{default:e(()=>[s("Form")]),_:1})]),n("li",null,[t(a,{to:"#multipart"},{default:e(()=>[s("Multipart")]),_:1})]),n("li",null,[t(a,{to:"#via-configuration"},{default:e(()=>[s("Via Configuration")]),_:1})])])]),m])}const b=o(r,[["render",g],["__file","data_format.html.vue"]]);export{b as default};
