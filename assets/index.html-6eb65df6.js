import{_ as i,M as l,p as r,q as u,R as s,N as a,U as e,t as n,a1 as c}from"./framework-efe98465.js";const d={},k=s("h1",{id:"release-notes",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#release-notes","aria-hidden":"true"},"#"),n(" Release Notes")],-1),h={class:"table-of-contents"},m=s("h2",{id:"support-policy",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#support-policy","aria-hidden":"true"},"#"),n(" Support Policy")],-1),v={href:"https://laravel.com/docs/10.x/releases",target:"_blank",rel:"noopener noreferrer"},g=c('<table><thead><tr><th>Version</th><th>PHP</th><th>Laravel</th><th>Release</th><th>Security Fixes Until</th></tr></thead><tbody><tr><td><code>8.x</code></td><td><code>8.2 - ?</code></td><td><code>v11.x</code></td><td><em>~1st Quarter 2024</em></td><td><em>TBD</em></td></tr><tr><td><code>7.x</code>*</td><td><code>8.1 - 8.2</code></td><td><code>v10.x</code></td><td>February 16th, 2023</td><td>February 2024</td></tr><tr><td><code>6.x</code></td><td><code>8.0 - 8.1</code></td><td><code>v9.x</code></td><td>April 5th, 2022</td><td>February 2023</td></tr><tr><td><code>5.x</code></td><td><code>7.4</code></td><td><code>v8.x</code></td><td>October 4th, 2020</td><td><em>N/A</em></td></tr><tr><td><code>&lt; 5.x</code></td><td><em>-</em></td><td><em>-</em></td><td><em>See <code>CHANGELOG.md</code></em></td><td><em>N/A</em></td></tr></tbody></table><p><em>*: current supported version.</em></p><p><em>TBD: &quot;To be decided&quot;.</em></p><h2 id="v7-x-highlights" tabindex="-1"><a class="header-anchor" href="#v7-x-highlights" aria-hidden="true">#</a> <code>v7.x</code> Highlights</h2><p>These are the highlights of the latest major version of Athenaeum.</p><h3 id="php-v8-1-and-laravel-v10-x" tabindex="-1"><a class="header-anchor" href="#php-v8-1-and-laravel-v10-x" aria-hidden="true">#</a> PHP <code>v8.1</code> and Laravel <code>v10.x</code></h3>',6),f=s("code",null,"v8.1",-1),b={href:"https://laravel.com/docs/10.x/releases",target:"_blank",rel:"noopener noreferrer"},_=s("code",null,"v10.x",-1),w=s("h3",{id:"http-conditional-requests",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#http-conditional-requests","aria-hidden":"true"},"#"),n(" Http Conditional Requests")],-1),y={href:"https://httpwg.org/specs/rfc9110.html#conditional.requests",target:"_blank",rel:"noopener noreferrer"},x={href:"https://httpwg.org/specs/rfc9110.html#field.if-match",target:"_blank",rel:"noopener noreferrer"},q={href:"https://httpwg.org/specs/rfc9110.html#field.if-unmodified-since",target:"_blank",rel:"noopener noreferrer"},S={href:"https://httpwg.org/specs/rfc9110.html#field.if-none-match",target:"_blank",rel:"noopener noreferrer"},R={href:"https://httpwg.org/specs/rfc9110.html#field.if-modified-since",target:"_blank",rel:"noopener noreferrer"},A={href:"https://httpwg.org/specs/rfc9110.html#field.if-range",target:"_blank",rel:"noopener noreferrer"},C=s("h3",{id:"downloadstream-response-helper",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#downloadstream-response-helper","aria-hidden":"true"},"#"),n(),s("code",null,"DownloadStream"),n(" Response Helper")],-1),P=s("code",null,"DownloadStream",-1),T=s("code",null,"Range",-1),H=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Facades<span class="token punctuation">\\</span>Route</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>ETags<span class="token punctuation">\\</span>Preconditions<span class="token punctuation">\\</span>Responses<span class="token punctuation">\\</span>DownloadStream</span><span class="token punctuation">;</span>

<span class="token class-name static-context">Route</span><span class="token operator">::</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/downloads/{file}&#39;</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token class-name type-declaration">DownloadFileRequest</span> <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>

    <span class="token keyword">return</span> <span class="token class-name static-context">DownloadStream</span><span class="token operator">::</span><span class="token function">for</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token property">resource</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">setName</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">route</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;file&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="api-requests" tabindex="-1"><a class="header-anchor" href="#api-requests" aria-hidden="true">#</a> API Requests</h3>`,2),$=c(`<p><strong>Example Request</strong></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Api<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>ShowSingleResourceRequest</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Eloquent<span class="token punctuation">\\</span>Model</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>User</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">ShowUser</span> <span class="token keyword">extends</span> <span class="token class-name">ShowSingleResourceRequest</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">findRecordOrFail</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token class-name return-type">Model</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token class-name static-context">User</span><span class="token operator">::</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">route</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;id&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">mustEvaluatePreconditions</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token constant boolean">true</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p><strong>Example Action</strong></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token class-name static-context">Route</span><span class="token operator">::</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users/{id}&#39;</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token class-name type-declaration">ShowUser</span> <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token class-name static-context">UserResource</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token property">record</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">withCache</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">name</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;users.show&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="api-resource-http-caching" tabindex="-1"><a class="header-anchor" href="#api-resource-http-caching" aria-hidden="true">#</a> Api Resource Http Caching</h3>`,5),E={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cache-Control",target:"_blank",rel:"noopener noreferrer"},F={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag",target:"_blank",rel:"noopener noreferrer"},I={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Last-Modified",target:"_blank",rel:"noopener noreferrer"},N=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token class-name static-context">Route</span><span class="token operator">::</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/addresses/{id}&#39;</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">AddressResource</span><span class="token punctuation">(</span><span class="token class-name static-context">Address</span><span class="token operator">::</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">withCache</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1),L=c(`<h3 id="custom-queries-for-search-and-sorting-filters" tabindex="-1"><a class="header-anchor" href="#custom-queries-for-search-and-sorting-filters" aria-hidden="true">#</a> Custom Queries for Search and Sorting Filters</h3><p>The <code>SearchFilter</code> and <code>SearchProcessor</code> now support custom search callbacks.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>Processors<span class="token punctuation">\\</span>SearchProcessor</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Builder</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Eloquent<span class="token punctuation">\\</span>Builder</span> <span class="token keyword">as</span> EloquentBuilder<span class="token punctuation">;</span>

<span class="token variable">$processor</span> <span class="token operator">=</span> <span class="token class-name static-context">SearchProcessor</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">columns</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token class-name">Builder</span><span class="token operator">|</span><span class="token class-name">EloquentBuilder</span> <span class="token variable">$query</span><span class="token punctuation">,</span> <span class="token keyword type-hint">string</span> <span class="token variable">$search</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token variable">$query</span>
                <span class="token operator">-&gt;</span><span class="token function">orWhere</span><span class="token punctuation">(</span><span class="token variable">$column</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;like&#39;</span><span class="token punctuation">,</span> <span class="token string double-quoted-string">&quot;<span class="token interpolation"><span class="token punctuation">{</span><span class="token variable">$search</span><span class="token punctuation">}</span></span>%&quot;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The same applies for the <code>SortFilter</code> and <code>SortingProcessor</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>Processors<span class="token punctuation">\\</span>SortingProcessor</span><span class="token punctuation">;</span>

<span class="token variable">$processor</span> <span class="token operator">=</span> <span class="token class-name static-context">SortingProcessor</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">sortable</span><span class="token punctuation">(</span><span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;email&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;name&#39;</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">withSortingCallback</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;email&#39;</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$query</span><span class="token punctuation">,</span> <span class="token variable">$column</span><span class="token punctuation">,</span> <span class="token variable">$direction</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token variable">$query</span><span class="token operator">-&gt;</span><span class="token function">orderBy</span><span class="token punctuation">(</span><span class="token string double-quoted-string">&quot;users.<span class="token interpolation"><span class="token punctuation">{</span><span class="token variable">$column</span><span class="token punctuation">}</span></span>&quot;</span><span class="token punctuation">,</span> <span class="token variable">$direction</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="remove-response-payload-middleware" tabindex="-1"><a class="header-anchor" href="#remove-response-payload-middleware" aria-hidden="true">#</a> Remove Response Payload Middleware</h3>`,6),M=c(`<h3 id="attach-file-stream-for-http-client" tabindex="-1"><a class="header-anchor" href="#attach-file-stream-for-http-client" aria-hidden="true">#</a> Attach File Stream for Http Client</h3><p>The Http Client now supports uploading a file stream.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Streams<span class="token punctuation">\\</span>FileStream</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>  
        <span class="token operator">-&gt;</span><span class="token function">attachStream</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;2023_annual.pdf&#39;</span><span class="token punctuation">,</span> <span class="token class-name static-context">FileStream</span><span class="token operator">::</span><span class="token function">open</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/reports/2023_annual.pdf&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;r&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">post</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/reports/annual&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="improved-status-object" tabindex="-1"><a class="header-anchor" href="#improved-status-object" aria-hidden="true">#</a> Improved Status object</h3>`,4),B=s("code",null,"Status",-1),D=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Responses<span class="token punctuation">\\</span>Status</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Teapot<span class="token punctuation">\\</span>StatusCode<span class="token punctuation">\\</span>All</span> <span class="token keyword">as</span> StatusCode<span class="token punctuation">;</span>

<span class="token variable">$client</span>
    <span class="token operator">-&gt;</span><span class="token function">expect</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Status</span> <span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$status</span><span class="token operator">-&gt;</span><span class="token function">isBadGateway</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token comment">// ...</span>
        <span class="token punctuation">}</span>
            
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$status</span><span class="token operator">-&gt;</span><span class="token function">is</span><span class="token punctuation">(</span><span class="token class-name static-context">StatusCode</span><span class="token operator">::</span><span class="token constant">UNPROCESSABLE_ENTITY</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token comment">// ...</span>
        <span class="token punctuation">}</span>
        
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$status</span><span class="token operator">-&gt;</span><span class="token function">satisfies</span><span class="token punctuation">(</span><span class="token punctuation">[</span> <span class="token class-name static-context">StatusCode</span><span class="token operator">::</span><span class="token constant">CREATED</span><span class="token punctuation">,</span> <span class="token class-name static-context">StatusCode</span><span class="token operator">::</span><span class="token constant">NO_CONTENT</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token comment">// ...</span>
        <span class="token punctuation">}</span>
        
        <span class="token comment">// ... etc</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="stream-hash-accept-hashing-options" tabindex="-1"><a class="header-anchor" href="#stream-hash-accept-hashing-options" aria-hidden="true">#</a> Stream <code>hash()</code> accept hashing options</h3>`,2),U={href:"https://www.php.net/manual/en/function.hash-init",target:"_blank",rel:"noopener noreferrer"},O=s("code",null,"hash()",-1),j=s("code",null,"v8.1",-1),G=s("h3",{id:"stream-sync-is-now-supported",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#stream-sync-is-now-supported","aria-hidden":"true"},"#"),n(" Stream "),s("code",null,"sync()"),n(" is now supported")],-1),V=s("code",null,"sync()",-1),Q=s("h3",{id:"to-memory-unit-method",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#to-memory-unit-method","aria-hidden":"true"},"#"),n(),s("code",null,"to()"),n(" memory unit method")],-1),W=s("code",null,"to()",-1),z=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">echo</span> <span class="token class-name static-context">Memory</span><span class="token operator">::</span><span class="token function">unit</span><span class="token punctuation">(</span><span class="token number">6_270_000_000</span><span class="token punctuation">)</span> <span class="token comment">// bytes</span>
    <span class="token operator">-&gt;</span><span class="token function">to</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;gigabyte&#39;</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// 6.27</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="changelog" tabindex="-1"><a class="header-anchor" href="#changelog" aria-hidden="true">#</a> Changelog</h2>`,2),Y={href:"https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md",target:"_blank",rel:"noopener noreferrer"};function J(K,X){const t=l("router-link"),o=l("ExternalLinkIcon"),p=l("RouterLink");return r(),u("div",null,[k,s("nav",h,[s("ul",null,[s("li",null,[a(t,{to:"#support-policy"},{default:e(()=>[n("Support Policy")]),_:1})]),s("li",null,[a(t,{to:"#v7-x-highlights"},{default:e(()=>[n("v7.x Highlights")]),_:1}),s("ul",null,[s("li",null,[a(t,{to:"#php-v8-1-and-laravel-v10-x"},{default:e(()=>[n("PHP v8.1 and Laravel v10.x")]),_:1})]),s("li",null,[a(t,{to:"#http-conditional-requests"},{default:e(()=>[n("Http Conditional Requests")]),_:1})]),s("li",null,[a(t,{to:"#downloadstream-response-helper"},{default:e(()=>[n("DownloadStream Response Helper")]),_:1})]),s("li",null,[a(t,{to:"#api-requests"},{default:e(()=>[n("API Requests")]),_:1})]),s("li",null,[a(t,{to:"#api-resource-http-caching"},{default:e(()=>[n("Api Resource Http Caching")]),_:1})]),s("li",null,[a(t,{to:"#custom-queries-for-search-and-sorting-filters"},{default:e(()=>[n("Custom Queries for Search and Sorting Filters")]),_:1})]),s("li",null,[a(t,{to:"#remove-response-payload-middleware"},{default:e(()=>[n("Remove Response Payload Middleware")]),_:1})]),s("li",null,[a(t,{to:"#attach-file-stream-for-http-client"},{default:e(()=>[n("Attach File Stream for Http Client")]),_:1})]),s("li",null,[a(t,{to:"#improved-status-object"},{default:e(()=>[n("Improved Status object")]),_:1})]),s("li",null,[a(t,{to:"#stream-hash-accept-hashing-options"},{default:e(()=>[n("Stream hash() accept hashing options")]),_:1})]),s("li",null,[a(t,{to:"#stream-sync-is-now-supported"},{default:e(()=>[n("Stream sync() is now supported")]),_:1})]),s("li",null,[a(t,{to:"#to-memory-unit-method"},{default:e(()=>[n("to() memory unit method")]),_:1})])])]),s("li",null,[a(t,{to:"#changelog"},{default:e(()=>[n("Changelog")]),_:1})])])]),m,s("p",null,[n("Athenaeum attempts to follow a release cycle that matches closely to that of "),s("a",v,[n("Laravel"),a(o)]),n(". However, due to limited amount of project maintainers, no guarantees can be provided.")]),g,s("p",null,[n("PHP version "),f,n(" is now the minimum required version for Athenaeum. "),s("a",b,[n("Laravel "),_,a(o)]),n(" packages are now used.")]),w,s("p",null,[n("The "),a(p,{to:"/archive/v7x/etags/"},{default:e(()=>[n("ETags package")]),_:1}),n(" has been upgraded to offer support for "),s("a",y,[n("RFC 9110's conditional requests"),a(o)]),n(". The following preconditions are supported by default:")]),s("ul",null,[s("li",null,[s("a",x,[n("If-Match"),a(o)])]),s("li",null,[s("a",q,[n("If-Unmodified-Since"),a(o)])]),s("li",null,[s("a",S,[n("If-None-Match"),a(o)])]),s("li",null,[s("a",R,[n("If-Modified-Since"),a(o)])]),s("li",null,[s("a",A,[n("If-Range"),a(o)])])]),s("p",null,[n("See "),a(p,{to:"/archive/v7x/etags/evaluator/"},{default:e(()=>[n("documentation")]),_:1}),n(" for details.")]),C,s("p",null,[n("As a part of the "),a(p,{to:"/archive/v7x/etags/evaluator/download-stream.html"},{default:e(()=>[n("ETags package")]),_:1}),n(", a "),P,n(" response helper is now available. It is able to create streamed response for "),T,n(" requests.")]),H,s("p",null,[n("The Http Api package has been upgraded with a few "),a(p,{to:"/archive/v7x/http/api/requests/"},{default:e(()=>[n("Request abstractions")]),_:1}),n(". These can speed up development of API endpoints.")]),$,s("p",null,[n("Additionally, Api Resources now have the ability to set "),s("a",E,[n("Caching headers"),a(o)]),n(", "),s("a",F,[n("ETag"),a(o)]),n(", and "),s("a",I,[n("Last-Modified date"),a(o)]),n(", via a single method:")]),N,s("p",null,[n("See "),a(p,{to:"/archive/v7x/http/api/resources/caching.html"},{default:e(()=>[n("documentation")]),_:1}),n(" for details.")]),L,s("p",null,[n("A new middleware has been added for the Http Api package, which is able to remove a response's body, when a custom query parameter is available. See "),a(p,{to:"/archive/v7x/http/api/middleware/remove-response-payload.html"},{default:e(()=>[n("middleware documentation")]),_:1}),n(" for details.")]),M,s("p",null,[n("The "),B,n(" object that is provided for "),a(p,{to:"/archive/v7x/http/clients/methods/expectations.html"},{default:e(()=>[n("response expectations")]),_:1}),n(" has been improved. It now contains several helper methods for determining if it matches a desired Http status code.")]),D,s("p",null,[n("Streams now accept and apply "),s("a",U,[n("hashing options"),a(o)]),n(" in "),O,n(" method. This was previously also supported, but required PHP "),j,n(". PHP version check is no longer performed internally. See "),a(p,{to:"/archive/v7x/streams/usage/hash.html"},{default:e(()=>[n("documentation")]),_:1}),n(" for more details.")]),G,s("p",null,[n("File streams can now have their content synchronised to file, via the "),V,n(" method. See "),a(p,{to:"/archive/v7x/streams/usage/sync.html"},{default:e(()=>[n("example")]),_:1}),n(".")]),Q,s("p",null,[n("The "),a(p,{to:"/archive/v7x/utils/memory.html"},{default:e(()=>[n("Memory")]),_:1}),n(" utility now offers a "),W,n(" method, which allows specifying a string unit to convert the memory unit into.")]),z,s("p",null,[n("Make sure to read the "),s("a",Y,[n("changelog"),a(o)]),n(" for additional information about the latest release, new features, changes and bug fixes.")])])}const nn=i(d,[["render",J],["__file","index.html.vue"]]);export{nn as default};
