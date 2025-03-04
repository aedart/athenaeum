import{_ as c,M as p,p as r,q as d,R as n,N as s,U as e,t as a,a1 as i}from"./framework-efe98465.js";const u={},h=n("h1",{id:"integration",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#integration","aria-hidden":"true"},"#"),a(" Integration")],-1),v=n("p",null,"In this chapter you will find information, on how to integrate the Athenaeum Core Application into your legacy application. Please take your time and read through this carefully.",-1),m={class:"table-of-contents"},k=i(`<h2 id="bootstrap-directory" tabindex="-1"><a class="header-anchor" href="#bootstrap-directory" aria-hidden="true">#</a> Bootstrap Directory</h2><p>Create a new directory to contain a application file. The directory <em>SHOULD</em> not be publicly available via the browser. You can call this directory for <code>bootstrap</code> or whatever makes sense to you.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>/bootstrap
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="the-application-file-app-php" tabindex="-1"><a class="header-anchor" href="#the-application-file-app-php" aria-hidden="true">#</a> The Application file (<code>app.php</code>)</h2><p>Inside your newly created <code>/bootstrap</code> directory, create a <code>app.php</code> file (<em>The filename does not matter</em>). This application file will create a new <code>Application</code> instance. It accepts an <code>array</code> of various directory paths. These paths are used throughout the <code>Application</code> and many of Laravel&#39;s components. It is therefore important that these directories exist. Edit these paths as you see fit.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token comment">// Create application instance, set the paths it must use</span>
<span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name class-name-fully-qualified"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Core<span class="token punctuation">\\</span>Application</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;basePath&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">dirname</span><span class="token punctuation">(</span><span class="token constant">__DIR__</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;bootstrapPath&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">dirname</span><span class="token punctuation">(</span><span class="token constant">__DIR__</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;configPath&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../configs&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;databasePath&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../database&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;environmentPath&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;resourcePath&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../resources&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;storagePath&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../storage&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;publicPath&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../public&#39;</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><div class="custom-container warning"><p class="custom-container-title">WARNING</p><p>With the exception of the <code>publicPath</code>, all paths shouldn&#39;t be publicly available via a browser. Please configure your web server to deny access to those paths, when requested via Http.</p></div>`,7),b={class:"custom-container tip"},g=n("p",{class:"custom-container-title"},"TIP",-1),_={href:"https://laravel.com/docs/7.x/structure#the-bootstrap-directory",target:"_blank",rel:"noopener noreferrer"},f=n("h2",{id:"the-environment-file-env",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#the-environment-file-env","aria-hidden":"true"},"#"),a(" The Environment File ("),n("code",null,".env"),a(")")],-1),y=n("code",null,"environmentPath",-1),w={href:"https://laravel.com/docs/7.x/configuration#environment-configuration",target:"_blank",rel:"noopener noreferrer"},x=n("code",null,".env",-1),q=i(`<div class="language-ini line-numbers-mode" data-ext="ini"><pre class="language-ini"><code><span class="token comment"># Application name</span>
<span class="token key attr-name">APP_NAME</span><span class="token punctuation">=</span><span class="token value attr-value">&quot;<span class="token inner-value">Athenaeum</span>&quot;</span>

<span class="token comment"># Application environment</span>
<span class="token key attr-name">APP_ENV</span><span class="token punctuation">=</span><span class="token value attr-value">&quot;<span class="token inner-value">production</span>&quot;</span>

<span class="token comment"># Exception Handling</span>
<span class="token key attr-name">EXCEPTION_HANDLING_ENABLED</span><span class="token punctuation">=</span><span class="token value attr-value">false</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1),I=n("thead",null,[n("tr",null,[n("th",null,"Name"),n("th",null,"Description")])],-1),A=n("tr",null,[n("td",null,[n("code",null,"APP_NAME")]),n("td",null,"Your application's name.")],-1),P=n("tr",null,[n("td",null,[n("code",null,"APP_ENV")]),n("td",null,`The application's environment, e.g. "production", "testing", "development"...etc.`)],-1),D=n("td",null,[n("code",null,"EXCEPTION_HANDLING_ENABLED")],-1),C=n("h2",{id:"the-console-application-cli-php",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#the-console-application-cli-php","aria-hidden":"true"},"#"),a(" The Console Application ("),n("code",null,"cli.php"),a(")")],-1),E=n("code",null,"cli.php",-1),T=n("code",null,"basePath",-1),N={href:"https://laravel.com/docs/7.x/artisan",target:"_blank",rel:"noopener noreferrer"},R=n("em",null,"a light version of Artisan",-1),$=i(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token comment">// Include composer&#39;s autoloader</span>
<span class="token keyword">require</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/vendor/autoload.php&#39;</span><span class="token punctuation">;</span>

<span class="token comment">// Obtain application instance</span>
<span class="token variable">$app</span> <span class="token operator">=</span> <span class="token keyword">require_once</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/bootstrap/app.php&#39;</span><span class="token punctuation">;</span>

<span class="token comment">// Create &quot;Console Kernel&quot; instance</span>
<span class="token variable">$kernel</span> <span class="token operator">=</span> <span class="token variable">$app</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Console<span class="token punctuation">\\</span>Kernel</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Run the application - handle input, assign output</span>
<span class="token variable">$status</span> <span class="token operator">=</span> <span class="token variable">$kernel</span><span class="token operator">-&gt;</span><span class="token function">handle</span><span class="token punctuation">(</span>
    <span class="token variable">$input</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name class-name-fully-qualified"><span class="token punctuation">\\</span>Symfony<span class="token punctuation">\\</span>Component<span class="token punctuation">\\</span>Console<span class="token punctuation">\\</span>Input<span class="token punctuation">\\</span>ArgvInput</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token keyword">new</span> <span class="token class-name class-name-fully-qualified"><span class="token punctuation">\\</span>Symfony<span class="token punctuation">\\</span>Component<span class="token punctuation">\\</span>Console<span class="token punctuation">\\</span>Output<span class="token punctuation">\\</span>ConsoleOutput</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Terminate and exist with status code</span>
<span class="token variable">$kernel</span><span class="token operator">-&gt;</span><span class="token function">terminate</span><span class="token punctuation">(</span><span class="token variable">$input</span><span class="token punctuation">,</span> <span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">exit</span><span class="token punctuation">(</span><span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>By now, you should be able to run the Console Application. Try the following:</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php cli.php
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>You should see an output similar to this:</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>Athenaeum <span class="token punctuation">(</span>via. Laravel Artisan ~ illuminate/console <span class="token number">6.16</span>.0<span class="token punctuation">)</span> <span class="token number">4.0</span>.0

Usage:
  <span class="token builtin class-name">command</span> <span class="token punctuation">[</span>options<span class="token punctuation">]</span> <span class="token punctuation">[</span>arguments<span class="token punctuation">]</span>

Options:
  -h, <span class="token parameter variable">--help</span>            Display this <span class="token builtin class-name">help</span> message
  -q, <span class="token parameter variable">--quiet</span>           Do not output any message
  -V, <span class="token parameter variable">--version</span>         Display this application version
      <span class="token parameter variable">--ansi</span>            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env<span class="token punctuation">[</span><span class="token operator">=</span>ENV<span class="token punctuation">]</span>       The environment the <span class="token builtin class-name">command</span> should run under
  -v<span class="token operator">|</span>vv<span class="token operator">|</span>vvv, <span class="token parameter variable">--verbose</span>  Increase the verbosity of messages: <span class="token punctuation">..</span>.

// <span class="token punctuation">..</span>. remaining not shown <span class="token punctuation">..</span>.
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="publish-assets" tabindex="-1"><a class="header-anchor" href="#publish-assets" aria-hidden="true">#</a> Publish Assets</h2><p>This package, along with it&#39;s dependencies, requires certain assets in order to be fully functional, e.g. configuration files. To make these assets available in your legacy application, you need to run the <code>vendor:publish-all</code> command, via your Console Application (<code>cli.php</code>). The command will publish all assets available assets into your application.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php cli.php vendor:publish-all
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>Once the command has completed, you should have a few configuration files available inside your <code>/configs</code> directory. Details regarding these files are covered in upcoming chapters. For now, it&#39;s important that these are available in your application.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>/configs
    app.php
    cache.php
    commands.php
    events.php
    exceptions.php
    schedule.php
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,10),L={class:"custom-container tip"},O=n("p",{class:"custom-container-title"},"Note",-1),S=n("code",null,"vendor:publish",-1),B=n("code",null,"vendor:publish-all",-1),F={href:"https://laravel.com/docs/7.x/artisan#writing-commands",target:"_blank",rel:"noopener noreferrer"},H=i(`<hr><h2 id="make-the-application-available" tabindex="-1"><a class="header-anchor" href="#make-the-application-available" aria-hidden="true">#</a> Make the Application Available</h2><p>Ideally your legacy application has a single entry point, e.g. a single <code>index.php</code>, located in your <code>/public</code> directory. Should this not be the case, don&#39;t worry about it. Multiple entry points is covered a bit later.</p><h3 id="single-entry-point" tabindex="-1"><a class="header-anchor" href="#single-entry-point" aria-hidden="true">#</a> Single Entry Point</h3><p>Inside you <code>index.php</code> (<em>or whatever your entry point might be called</em>), require the <code>app.php</code> file and invoke the <code>run()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token comment">// Include composer&#39;s autoload</span>
<span class="token keyword">require_once</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../vendor/autoload.php&#39;</span><span class="token punctuation">;</span>

<span class="token comment">// Obtain the application instance</span>
<span class="token variable">$app</span> <span class="token operator">=</span> <span class="token keyword">require_once</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../bootstrap/app.php&#39;</span><span class="token punctuation">;</span>

<span class="token comment">// Run the application</span>
<span class="token variable">$app</span><span class="token operator">-&gt;</span><span class="token function">run</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ... your legacy application logic here ...</span>

<span class="token comment">// Terminate and destroy the application instance</span>
<span class="token variable">$app</span><span class="token operator">-&gt;</span><span class="token function">terminate</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$app</span><span class="token operator">-&gt;</span><span class="token function">destroy</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h4 id="bootstrap-register-and-boot" tabindex="-1"><a class="header-anchor" href="#bootstrap-register-and-boot" aria-hidden="true">#</a> Bootstrap, Register and Boot</h4>`,7),M=n("code",null,"run()",-1),V={href:"https://laravel.com/docs/7.x/providers",target:"_blank",rel:"noopener noreferrer"},G=n("h4",{id:"graceful-shutdown",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#graceful-shutdown","aria-hidden":"true"},"#"),a(" Graceful Shutdown")],-1),Y=n("code",null,"terminate()",-1),U=n("code",null,"destroy()",-1),K={href:"https://en.wikipedia.org/wiki/Graceful_exit",target:"_blank",rel:"noopener noreferrer"},W=i(`<h3 id="multiple-entry-points" tabindex="-1"><a class="header-anchor" href="#multiple-entry-points" aria-hidden="true">#</a> Multiple Entry Points</h3><p>Should your legacy application have multiple entry points, then you can add additional helper files within your <code>/bootstrap</code> directory. The following illustrates a possible method, of how you could deal with multiple entry points.</p><h4 id="header-file" tabindex="-1"><a class="header-anchor" href="#header-file" aria-hidden="true">#</a> Header File</h4><p>Create a new <code>header.php</code> file, in which you require the application and invoke the <code>run()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token comment">// Include composer&#39;s autoload</span>
<span class="token keyword">require_once</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../vendor/autoload.php&#39;</span><span class="token punctuation">;</span>

<span class="token comment">// Obtain the application instance</span>
<span class="token variable">$app</span> <span class="token operator">=</span> <span class="token keyword">require_once</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/app.php&#39;</span><span class="token punctuation">;</span>

<span class="token comment">// Run the application</span>
<span class="token variable">$app</span><span class="token operator">-&gt;</span><span class="token function">run</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h4 id="footer-file" tabindex="-1"><a class="header-anchor" href="#footer-file" aria-hidden="true">#</a> Footer File</h4><p>Create a <code>footer.php</code> file to handle the application&#39;s graceful shutdown. Invoke the <code>terminate()</code> and <code>destroy()</code> methods.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token comment">// Terminate and destroy the application instance</span>
<span class="token keyword">if</span><span class="token punctuation">(</span><span class="token keyword">isset</span><span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
    <span class="token variable">$app</span><span class="token operator">-&gt;</span><span class="token function">terminate</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    
    <span class="token variable">$app</span><span class="token operator">-&gt;</span><span class="token function">destroy</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> 
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h4 id="your-entry-points" tabindex="-1"><a class="header-anchor" href="#your-entry-points" aria-hidden="true">#</a> Your Entry Points</h4><p>Include <code>header.php</code> and <code>footer.php</code> in each of your entry points. Ensure that these files are included in the top and bottom part of your entry points.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token comment">// Include the header file</span>
<span class="token keyword">require_once</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../bootstrap/header.php&#39;</span><span class="token punctuation">;</span>

<span class="token comment">// ... your entry-point logic here ...</span>

<span class="token comment">// Include the footer file</span>
<span class="token keyword">require_once</span> <span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../bootstrap/footer.php&#39;</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,11),X={class:"custom-container warning"},j=n("p",{class:"custom-container-title"},"Caution",-1),z={href:"https://www.php.net/manual/en/function.require-once.php",target:"_blank",rel:"noopener noreferrer"},J=n("code",null,"require_once",-1),Q=n("code",null,"header.php",-1),Z=n("code",null,"footer.php",-1),nn=n("h2",{id:"onward",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#onward","aria-hidden":"true"},"#"),a(" Onward")],-1),an=n("p",null,"Hopefully, by now you have an application up and running. For the remainder of this package's documentation, example usages of the major components are illustrated. Even if your are a seasoned Laravel developer, you should take some time to browse through it. It might give you some perspectives and helpful information about how this package can be used.",-1);function sn(en,tn){const t=p("router-link"),o=p("ExternalLinkIcon"),l=p("RouterLink");return r(),d("div",null,[h,v,n("nav",m,[n("ul",null,[n("li",null,[s(t,{to:"#bootstrap-directory"},{default:e(()=>[a("Bootstrap Directory")]),_:1})]),n("li",null,[s(t,{to:"#the-application-file-app-php"},{default:e(()=>[a("The Application file (app.php)")]),_:1})]),n("li",null,[s(t,{to:"#the-environment-file-env"},{default:e(()=>[a("The Environment File (.env)")]),_:1})]),n("li",null,[s(t,{to:"#the-console-application-cli-php"},{default:e(()=>[a("The Console Application (cli.php)")]),_:1})]),n("li",null,[s(t,{to:"#publish-assets"},{default:e(()=>[a("Publish Assets")]),_:1})]),n("li",null,[s(t,{to:"#make-the-application-available"},{default:e(()=>[a("Make the Application Available")]),_:1}),n("ul",null,[n("li",null,[s(t,{to:"#single-entry-point"},{default:e(()=>[a("Single Entry Point")]),_:1})]),n("li",null,[s(t,{to:"#multiple-entry-points"},{default:e(()=>[a("Multiple Entry Points")]),_:1})])])]),n("li",null,[s(t,{to:"#onward"},{default:e(()=>[a("Onward")]),_:1})])])]),k,n("div",b,[g,n("p",null,[a("You can read more about the directory structure, e.g. what each directory is intended for, inside "),n("a",_,[a("Laravel's documentation"),s(o)]),a(".")])]),f,n("p",null,[a("In your "),y,a(", create an "),n("a",w,[a("environment file"),s(o)]),a(" ("),x,a("). At the very minimum, it should contain the following:")]),q,n("table",null,[I,n("tbody",null,[A,P,n("tr",null,[D,n("td",null,[a("Enabling or disabling of Athenaeum Core Application's "),s(l,{to:"/archive/v4x/core/usage/exceptions.html"},{default:e(()=>[a("exception handling")]),_:1}),a(".")])])])]),C,n("p",null,[a("Create a "),E,a(" file inside your "),T,a(". Once again, the naming of the file does not matter. This file is where Laravel's "),n("a",N,[a("Console Application"),s(o)]),a(" ("),R,a(") is going to be created.")]),$,n("div",L,[O,n("p",null,[n("em",null,[a("If you are familiar with Laravel's "),S,a(" command, you will immediately notice that this publish assets command does not offer the same features, as the one provided by Laravel. The "),B,a(" is inspired by Laravel's publish command, yet it is not intended to offer the exact same features. Should you require more advanced publish features, then you will have to "),n("a",F,[a("create your own"),s(o)]),a(" publish command.")])])]),H,n("p",null,[a("In the above example, when the "),M,a(" method is invoked, the Athenaeum Core Application will bootstrap, register and boot it's registered "),n("a",V,[a("Service Providers"),s(o)]),a(". If this is done before your legacy application's logic, then all registered services are made available throughout the remaining of the incoming Http request.")]),G,n("p",null,[a("In the bottom path of the example, the "),Y,a(" and "),U,a(" methods are invoked. This allows registered services to perform "),n("a",K,[a("graceful shutdown logic"),s(o)]),a(", before the application instance along with it's registered services are destroyed. Invoking these methods can be omitted, yet it is not advisable.")]),W,n("div",X,[j,n("p",null,[a("Please make sure to use the "),n("a",z,[J,s(o)]),a(" method, to avoid that your bootstrap files ("),Q,a(" and "),Z,a(") are not included multiple times, if your application includes entry points into each other.")])]),nn,an])}const pn=c(u,[["render",sn],["__file","integration.html.vue"]]);export{pn as default};
