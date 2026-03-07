
import shutil
import os
# Define the source and destination folders
source_folder = 'smj-ulm-cal'
destination_folder = r"C:\xampp\htdocs\wordpress\wp-content\plugins\smj-ulm-cal"

# Iterate over all files and directories in the source folder
for item in os.listdir(source_folder):
    source_item = os.path.join(source_folder, item)
    destination_item = os.path.join(destination_folder, item)

    # Check if it's a file or directory and copy accordingly
    if os.path.isdir(source_item):
        # Copy directory and overwrite if exists
        if not os.path.exists(destination_item):
            shutil.copytree(source_item, destination_item)
        else:
            # If directory exists, recursively copy files into it
            for root, dirs, files in os.walk(source_item):
                for file in files:
                    source_file = os.path.join(root, file)
                    destination_file = os.path.join(destination_item, os.path.relpath(source_file, source_item))
                    os.makedirs(os.path.dirname(destination_file), exist_ok=True)
                    shutil.copy2(source_file, destination_file)
    else:
        # If it's a file, copy and overwrite if it already exists
        shutil.copy2(source_item, destination_item)