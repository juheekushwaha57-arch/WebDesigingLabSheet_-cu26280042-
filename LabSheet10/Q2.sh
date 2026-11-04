git checkout -b feature-branch
echo "New update" > update.txt
git add update.txt
git commit -m "Added feature update"
git checkout main
# (Simulate/resolve merge conflict if any)
git merge feature-branch
git remote add origin https://github.com/your-username/your-repo.git
git push -u origin main
