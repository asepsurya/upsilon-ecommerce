import os
import re

views_dir = r"resources/views"

for root, dirs, files in os.walk(views_dir):
    for file in files:
        if file.endswith(".blade.php") and file != "app.blade.php":
            path = os.path.join(root, file)
            with open(path, "r", encoding="utf-8") as f:
                content = f.read()

            if "<!DOCTYPE html>" in content:
                print(f"Refactoring {path}")
                
                # Extract title
                title_match = re.search(r"<title>(.*?)</title>", content, re.DOTALL)
                title_php = ""
                if title_match:
                    title_text = title_match.group(1).strip()
                    title_php = f"@section(\"title\")\n{title_text}\n@endsection\n"

                # Extract everything between <main> and </main>
                main_match = re.search(r"<main.*?>(.*?)</main>", content, re.DOTALL)
                if not main_match:
                    # if no main, try between @include(\"partials.header\") and @include(\"partials.footer\")
                    body_match = re.search(r"@include\('partials\.header'\)(.*?)@include\('partials\.footer'\)", content, re.DOTALL)
                    if body_match:
                        inner_content = body_match.group(1).strip()
                    else:
                        print(f"  Skipping {path} - no main or header/footer found")
                        # Some views like welcome.blade.php or admin might have different structures
                        # Let's check for body
                        body_only_match = re.search(r"<body.*?>(.*?)</body>", content, re.DOTALL)
                        if body_only_match:
                            inner_content = body_only_match.group(1).strip()
                        else:
                            continue
                else:
                    inner_content = main_match.group(1).strip()

                # Extract extra head scripts if any (e.g. ld+json)
                head_match = re.search(r"<head>(.*?)</head>", content, re.DOTALL)
                head_scripts = ""
                if head_match:
                    head_content = head_match.group(1)
                    scripts = re.findall(r"<script.*?>.*?</script>", head_content, re.DOTALL)
                    for script in scripts:
                        if "tailwindcss" not in script and "tailwind-config" not in script:
                            head_scripts += script + "\n"

                new_content = "@extends(\"layouts.app\")\n\n"
                
                if title_php:
                    new_content += title_php + "\n"
                    
                if head_scripts:
                    new_content += "@push(\"head\")\n" + head_scripts + "@endpush\n\n"
                
                new_content += "@section(\"content\")\n"
                new_content += inner_content + "\n"
                new_content += "@endsection\n"
                
                with open(path, "w", encoding="utf-8") as f:
                    f.write(new_content)
