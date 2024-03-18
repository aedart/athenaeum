import{_ as l,M as p,p as c,q as r,R as n,N as a,U as t,t as s,a1 as o}from"./framework-efe98465.js";const u={},d=n("h1",{id:"setup",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#setup","aria-hidden":"true"},"#"),s(" Setup")],-1),v={class:"table-of-contents"},m=o(`<h2 id="register-service-provider" tabindex="-1"><a class="header-anchor" href="#register-service-provider" aria-hidden="true">#</a> Register Service Provider</h2><p>Register <code>HttpClientServiceProvider</code> inside your <code>configs/app.php</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>HttpClientServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="publish-assets" tabindex="-1"><a class="header-anchor" href="#publish-assets" aria-hidden="true">#</a> Publish Assets</h2><p>Run <code>vendor:publish</code> to publish this package&#39;s assets.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan vendor:publish
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>After the command has completed, you should see the following configuration file in your <code>/configs</code> directory:</p><ul><li><code>http-clients.php</code></li></ul><h3 id="publish-assets-for-athenaeum-core-application" tabindex="-1"><a class="header-anchor" href="#publish-assets-for-athenaeum-core-application" aria-hidden="true">#</a> Publish Assets for Athenaeum Core Application</h3><p>If you are using the <a href="../../core">Athenaeum Core Application</a>, then run the following command to publish assets:</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php <span class="token punctuation">{</span>your-cli-app<span class="token punctuation">}</span> vendor:publish-all
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="configuration" tabindex="-1"><a class="header-anchor" href="#configuration" aria-hidden="true">#</a> Configuration</h2><p>In your <code>/configs/http-clients.php</code> configuration, you should see a list of &quot;profiles&quot;. Feel free to add as many profiles as your application requires.</p><p>Each profile consists of two keys:</p><ul><li><code>driver</code>: Class patch to the Http Client &quot;driver&quot; to be used.</li><li><code>options</code>: Http Client options.</li></ul>`,15),k={href:"http://docs.guzzlephp.org/en/stable/request-options.html",target:"_blank",rel:"noopener noreferrer"},g=o(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown</span>

    <span class="token comment">/*
     |--------------------------------------------------------------------------
     | Http Client Profiles
     |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span>    <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>DefaultHttpClient</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span>   <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                <span class="token string single-quoted-string">&#39;data_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>GuzzleHttp<span class="token punctuation">\\</span>RequestOptions</span><span class="token operator">::</span><span class="token constant">FORM_PARAMS</span><span class="token punctuation">,</span>                
                <span class="token string single-quoted-string">&#39;grammar-profile&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;HTTP_QUERY_GRAMMAR&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;default&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>

        <span class="token string single-quoted-string">&#39;json&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span>    <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>JsonHttpClient</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span>   <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                
                <span class="token string single-quoted-string">&#39;grammar-profile&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;json_api&#39;</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>

        <span class="token comment">// Add your own profiles... e.g. a preconfigured json http client</span>
        <span class="token string single-quoted-string">&#39;flights-api-client&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span>    <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>JsonHttpClient</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span>   <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;base_uri&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;https://acme.com/api/v2/flights&#39;</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;grammar-profile&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;odata&#39;</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span>
    
    <span class="token comment">// ... remaining not shown ...</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="http-query-grammars" tabindex="-1"><a class="header-anchor" href="#http-query-grammars" aria-hidden="true">#</a> Http Query Grammars</h3><p>Each Http Client profile can specify it&#39;s desired Http Query Grammars profile to use. The following grammars are offered by default:</p>`,3),b=n("li",null,[n("code",null,"DefaultGrammar"),s(": Does not follow any specific syntax or convention.")],-1),h=n("code",null,"JsonApiGrammar",-1),f={href:"https://jsonapi.org/format/1.1/#fetching",target:"_blank",rel:"noopener noreferrer"},q=n("code",null,"ODataGrammar",-1),_={href:"https://www.odata.org/getting-started/basic-tutorial/#queryData",target:"_blank",rel:"noopener noreferrer"},y=o(`<p>You can find a matching profile, inside your <code>configs/http-clients.php</code>, where you may change any of the available options.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>
    <span class="token comment">// ... previous not shown ...</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;json&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>JsonHttpClient</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token comment">// Http Query grammar profile to use</span>
                <span class="token string single-quoted-string">&#39;grammar-profile&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;json_api&#39;</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token comment">/*
     |--------------------------------------------------------------------------
     | Http Query Grammars
     |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;grammars&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

            <span class="token string single-quoted-string">&#39;json_api&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Grammars<span class="token punctuation">\\</span>JsonApiGrammar</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                    <span class="token string single-quoted-string">&#39;datetime_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>DateTimeInterface</span><span class="token operator">::</span><span class="token constant">ISO8601</span><span class="token punctuation">,</span>
                    <span class="token string single-quoted-string">&#39;date_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Y-m-d&#39;</span><span class="token punctuation">,</span>
                    <span class="token string single-quoted-string">&#39;year_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Y&#39;</span><span class="token punctuation">,</span>
                    <span class="token string single-quoted-string">&#39;month_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;m&#39;</span><span class="token punctuation">,</span>
                    <span class="token string single-quoted-string">&#39;day_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;d&#39;</span><span class="token punctuation">,</span>
                    <span class="token string single-quoted-string">&#39;time_format&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;H:i:s&#39;</span><span class="token punctuation">,</span>

                    <span class="token comment">// ... remaining not shown ...</span>
                <span class="token punctuation">]</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>

            <span class="token comment">// ... remaining not shown ...</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,2);function x(A,w){const e=p("router-link"),i=p("ExternalLinkIcon");return c(),r("div",null,[d,n("nav",v,[n("ul",null,[n("li",null,[a(e,{to:"#register-service-provider"},{default:t(()=>[s("Register Service Provider")]),_:1})]),n("li",null,[a(e,{to:"#publish-assets"},{default:t(()=>[s("Publish Assets")]),_:1}),n("ul",null,[n("li",null,[a(e,{to:"#publish-assets-for-athenaeum-core-application"},{default:t(()=>[s("Publish Assets for Athenaeum Core Application")]),_:1})])])]),n("li",null,[a(e,{to:"#configuration"},{default:t(()=>[s("Configuration")]),_:1}),n("ul",null,[n("li",null,[a(e,{to:"#http-query-grammars"},{default:t(()=>[s("Http Query Grammars")]),_:1})])])])])]),m,n("p",null,[s("You can use "),n("a",k,[s("Guzzle's Request Options"),a(i)]),s(", for each client profile.")]),g,n("ul",null,[b,n("li",null,[h,s(": Adheres to "),n("a",f,[s("Json API's"),a(i)]),s(" syntax for Http Queries.")]),n("li",null,[q,s(": Adheres to "),n("a",_,[s("OData's"),a(i)]),s(" syntax for Http Queries.")])]),y])}const C=l(u,[["render",x],["__file","setup.html.vue"]]);export{C as default};
