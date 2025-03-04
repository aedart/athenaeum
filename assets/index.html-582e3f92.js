import{_ as i,M as t,p as r,q as l,R as e,t as s,N as a,U as c,a1 as p}from"./framework-efe98465.js";const d={},u=e("h1",{id:"introduction",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#introduction","aria-hidden":"true"},"#"),s(" Introduction")],-1),h=e("em",null,"or building",-1),m=e("code",null,"config/http-clients.php",-1),g=p(`<h2 id="example" tabindex="-1"><a class="header-anchor" href="#example" aria-hidden="true">#</a> Example</h2><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">where</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;last_name&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;thomsen&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">where</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;age&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;gt&#39;</span><span class="token punctuation">,</span> <span class="token number">31</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;https://acme.org/api/v1/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="performed-request" tabindex="-1"><a class="header-anchor" href="#performed-request" aria-hidden="true">#</a> Performed Request</h3><p>The following illustrates the request that was sent, from previous example. Each tab shows the http request that was sent, using a different Http Query Grammar.</p><details class="custom-container details"><summary>default</summary><p>Builds query strings, yet does not follow any specific convention or standard.</p><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>GET https://acme.org/api/v1/users?last_name=thomsen&amp;age[gt]=31
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details>`,5),f={class:"custom-container details"},_=e("summary",null,"json api",-1),v={href:"https://jsonapi.org/format/1.1/#fetching",target:"_blank",rel:"noopener noreferrer"},k=e("div",{class:"language-http line-numbers-mode","data-ext":"http"},[e("pre",{class:"language-http"},[e("code",null,`GET https://acme.org/api/v1/users?filter[last_name]=thomsen&filter[age][gt]=31
`)]),e("div",{class:"line-numbers","aria-hidden":"true"},[e("div",{class:"line-number"})])],-1),b={class:"custom-container details"},x=e("summary",null,"odata",-1),y={href:"https://www.odata.org/getting-started/basic-tutorial/#queryData",target:"_blank",rel:"noopener noreferrer"},q=e("div",{class:"language-http line-numbers-mode","data-ext":"http"},[e("pre",{class:"language-http"},[e("code",null,"GET https://acme.org/api/v1/users?$filter=last_name eq `thomsen` and age gt 31\n")]),e("div",{class:"line-numbers","aria-hidden":"true"},[e("div",{class:"line-number"})])],-1);function w(E,B){const o=t("RouterLink"),n=t("ExternalLinkIcon");return r(),l("div",null,[u,e("p",null,[s("The Http Client contains a powerful Http Query Builder. It gives you the possibility to set query parameters fluently, and it supports a few grammars. These grammars are responsible for assembling ("),h,s(") the actual http query string. Each offer a few options, which can be specified via your "),m,s(" configuration. Read the "),a(o,{to:"/archive/v8x/http/clients/setup.html#http-query-grammars"},{default:c(()=>[s("configuration")]),_:1}),s(" chapter, for additional information about how to configure your desired grammar.")]),g,e("details",f,[_,e("p",null,[s("Builds query strings according to "),e("a",v,[s("Json API's recommendations"),a(n)]),s(".")]),k]),e("details",b,[x,e("p",null,[s("Builds query strings according to "),e("a",y,[s("OData v4"),a(n)]),s("'s syntax.")]),q])])}const I=i(d,[["render",w],["__file","index.html.vue"]]);export{I as default};
