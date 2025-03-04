import{_ as r,M as i,p as d,q as c,R as s,N as e,U as n,t as a,a1 as p}from"./framework-efe98465.js";const u={},m=s("h1",{id:"dates",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#dates","aria-hidden":"true"},"#"),a(" Dates")],-1),h=s("p",null,"The Http Query builder offers a few methods for adding date-based conditions, in you query string.",-1),g={class:"table-of-contents"},v=s("h2",{id:"formats",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#formats","aria-hidden":"true"},"#"),a(" Formats")],-1),k=s("code",null,"config/http-clients.php",-1),b={href:"https://www.php.net/manual/en/datetime.format.php",target:"_blank",rel:"noopener noreferrer"},f=s("code",null,"DateTime::format()",-1),y=p(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ...</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Grammars<span class="token punctuation">\\</span>DefaultGrammar</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                <span class="token doc-comment comment">/**
                 * Date formats
                 */</span>
                <span class="token string single-quoted-string">&#39;datetime_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>DateTimeInterface</span><span class="token operator">::</span><span class="token constant">ISO8601</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;date_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Y-m-d&#39;</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;year_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Y&#39;</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;month_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;m&#39;</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;day_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;d&#39;</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;time_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;H:i:s&#39;</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="arguments" tabindex="-1"><a class="header-anchor" href="#arguments" aria-hidden="true">#</a> Arguments</h2><p>Each of the available date-based condition methods accept the following arguments:</p><ul><li><code>$field</code>: <code>string</code> field/filter name</li><li><code>$operator</code>: <code>string|DateTimeInterface</code> string operator or value</li><li><code>$value</code>: <code>string|DateTimeInterface</code> (<em>optional</em>) date, either as a string or instance that inherits from <code>DateTimeInterface</code>. If omitted, the <code>$operator</code> acts as the value.</li></ul><p>If no value is given, then the current datetime (<code>now</code>) is used as the default value.</p><h2 id="where-datetime" tabindex="-1"><a class="header-anchor" href="#where-datetime" aria-hidden="true">#</a> Where Datetime</h2><p>The <code>whereDatetime()</code> adds a condition using a full &quot;date &amp; time&quot; format.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">whereDatetime</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;created&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;2020-04-05&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?created=2020-04-05T00:00:00+0000
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?filter[created]=2020-04-05T00:00:00+0000
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$filter=created eq 2020-04-05T00:00:00+0000
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="where-date" tabindex="-1"><a class="header-anchor" href="#where-date" aria-hidden="true">#</a> Where Date</h2><p><code>whereDate()</code> can be used to add a condition where &quot;year, month and day&quot; formats are expected.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">whereDate</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;created&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;gt&#39;</span><span class="token punctuation">,</span> <span class="token keyword">new</span> <span class="token class-name">DateTime</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;now&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?created[gt]=2020-04-05
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?filter[created][gt]=2020-04-05
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$filter=created gt 2020-04-05
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="where-year" tabindex="-1"><a class="header-anchor" href="#where-year" aria-hidden="true">#</a> Where Year</h2><p><code>whereYear()</code> adds a date condition, where &quot;year&quot; is used as format.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">whereYear</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;created&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;lt&#39;</span><span class="token punctuation">,</span> <span class="token keyword">new</span> <span class="token class-name">DateTime</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;now&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?created[lt]=2020
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?filter[created][lt]=2020
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$filter=created lt 2020
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="where-month" tabindex="-1"><a class="header-anchor" href="#where-month" aria-hidden="true">#</a> Where Month</h2><p><code>whereMonth()</code> adds a condition, where &quot;month&quot; is used as format.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">whereMonth</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;created&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;2020-07-15&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?created=07
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?filter[created]=07
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$filter=created eq 07
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="where-day" tabindex="-1"><a class="header-anchor" href="#where-day" aria-hidden="true">#</a> Where Day</h2><p>To add a condition where &quot;day&quot; format is expected, use the <code>whereDay()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">whereDay</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;created&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;gt&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;2020-07-15&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?created[gt]=15
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?filter[created][gt]=15
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$filter=created gt 15
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="where-time" tabindex="-1"><a class="header-anchor" href="#where-time" aria-hidden="true">#</a> Where Time</h2><p>Conditions based on &quot;time&quot; format, can be added via <code>whereTime()</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">whereTime</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;created&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;lt&#39;</span><span class="token punctuation">,</span> <span class="token keyword">new</span> <span class="token class-name">DateTime</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;now&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><details class="custom-container details"><summary>default</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?created[lt]=16:58:00
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>json api</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?filter[created][lt]=16:58:00
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><details class="custom-container details"><summary>odata</summary><div class="language-http line-numbers-mode" data-ext="http"><pre class="language-http"><code>/users?$filter=created lt 16:58:00
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div></details><h2 id="or-methods" tabindex="-1"><a class="header-anchor" href="#or-methods" aria-hidden="true">#</a> Or Methods</h2>`,42),_=s("code",null,"orWhereDatetime()",-1),w=s("code",null,"orWhereDate()",-1),q=s("code",null,"orWhereYear()",-1),x={href:"https://www.odata.org/getting-started/basic-tutorial/#queryData",target:"_blank",rel:"noopener noreferrer"},D=s("strong",null,"NOT considered conventional",-1),T=s("code",null,"orWhere()",-1);function $(W,I){const t=i("router-link"),l=i("ExternalLinkIcon"),o=i("RouterLink");return d(),c("div",null,[m,h,s("nav",g,[s("ul",null,[s("li",null,[e(t,{to:"#formats"},{default:n(()=>[a("Formats")]),_:1})]),s("li",null,[e(t,{to:"#arguments"},{default:n(()=>[a("Arguments")]),_:1})]),s("li",null,[e(t,{to:"#where-datetime"},{default:n(()=>[a("Where Datetime")]),_:1})]),s("li",null,[e(t,{to:"#where-date"},{default:n(()=>[a("Where Date")]),_:1})]),s("li",null,[e(t,{to:"#where-year"},{default:n(()=>[a("Where Year")]),_:1})]),s("li",null,[e(t,{to:"#where-month"},{default:n(()=>[a("Where Month")]),_:1})]),s("li",null,[e(t,{to:"#where-day"},{default:n(()=>[a("Where Day")]),_:1})]),s("li",null,[e(t,{to:"#where-time"},{default:n(()=>[a("Where Time")]),_:1})]),s("li",null,[e(t,{to:"#or-methods"},{default:n(()=>[a("Or Methods")]),_:1})])])]),v,s("p",null,[a("Before showing examples of each supported method, you should know that you can change the date and time formats, for each grammar. This can be done in your "),k,a(" configuration file, under each grammar profile. The formats are parsed using PHP's "),s("a",b,[f,a(" method"),e(l)]),a(".")]),y,s("p",null,[a("You may also use the "),_,a(", "),w,a(", "),q,a('...etc methods to add "or" conjunctions. But, apart from '),s("a",x,[a("OData"),e(l)]),a(", these are "),D,a('. For additional information about "or" conjunctions, please read the '),e(o,{to:"/archive/v6x/http/clients/query/where.html#or-where"},{default:n(()=>[T,a(" documentation")]),_:1}),a(".")])])}const Y=r(u,[["render",$],["__file","dates.html.vue"]]);export{Y as default};
