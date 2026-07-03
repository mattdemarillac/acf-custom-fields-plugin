#!/usr/bin/env bash

set -e

PLUGIN_DIR="custom-site-functions"
BUILD_DIR="release"
ZIP_NAME="custom-site-functions.zip"

echo "🧹 Cleaning old build..."
rm -rf "$BUILD_DIR"
mkdir -p "$BUILD_DIR/$PLUGIN_DIR"
echo "📦 Copying plugin files..."

# OPTION 1: if plugin is in a folder
if [ -d "$PLUGIN_DIR" ]; then
  rsync -av \
    "$PLUGIN_DIR/" \
    "$BUILD_DIR/$PLUGIN_DIR/"
else

  echo "⚠️ Plugin folder not found, assuming root plugin structure"
  rsync -av \
    . \
    "$BUILD_DIR/$PLUGIN_DIR/" \
    --exclude ".git" \
    --exclude ".github" \
    --exclude "release" \
    --exclude "build.sh"
fi

echo "🗜️ Creating ZIP..."

cd "$BUILD_DIR"

zip -r "$ZIP_NAME" "$PLUGIN_DIR" > /dev/null

cd ..

echo "✅ Done!"
echo "📦 Output: $BUILD_DIR/$ZIP_NAME"